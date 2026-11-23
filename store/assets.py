import json, shutil, pathlib
from glob import glob


def main():
    array = dict()
    if pathlib.Path('../assetdata').exists():
        shutil.rmtree('../assetdata')
    pathlib.Path('../assetdata').mkdir(exist_ok=True, parents=True)
    for i in glob('./assets/*/*/meta.json'):
        path = pathlib.Path(i)
        array[path.parent.parent.name] = array.get(path.parent.parent.name, dict())
        array[path.parent.parent.name][path.parent.name] = array[path.parent.parent.name].get(path.parent.name, dict())
        with open(i, 'rt', encoding='utf8') as file:
            data = json.loads(file.read())
            array[path.parent.parent.name][path.parent.name]['data'] = data
        parental_name = f'{path.parent.parent.name}-{path.parent.name}'
        for suffix in ('.svg.php', '-Front.svg.php', '-Back.svg.php'):
            fn = parental_name + suffix
            if not path.with_name('main' + suffix).exists(): continue
            src_path = path.with_name('main' + suffix)
            if data.get('dev-mode'):
                print('dev-mode found at', repr(data.get('name')), f'id={path.parent.parent.name}')
                with open(pathlib.Path('../assetdata') / fn, 'wt', encoding='utf8') as out:
                    doc_root = "$_SERVER['DOCUMENT_ROOT']"
                    out.write('<?= "<!-- Dev Mode Enabled -->";')
                    out.write(f'\x20require_once\x20\"{{{doc_root}}}/dollmaker3/store/assets/')
                    out.write(f"{path.parent.parent.name}/{path.parent.name}/{src_path.name}\";")
            else:
                copyfile(src_path, pathlib.Path('../assetdata') / fn)
            match suffix:
                case '.svg.php':
                    array[path.parent.parent.name][path.parent.name]['fn'] = fn
                case '-Front.svg.php':
                    array[path.parent.parent.name][path.parent.name]['Front'] = fn
                case '-Back.svg.php':
                    array[path.parent.parent.name][path.parent.name]['Back'] = fn
    new = dict()
    listing = set()
    for key, value in sorted(array.items(), key=sorter):
        new[key] = array[key]
        if bodyname := array[key].get('f-', dict()).get('data', dict()).get('BaseBodyName'):
            listing.add(bodyname)
    listing.remove('new-phase')
    listing = ['new-phase'] + sorted(listing)
    jsonic = dict(d=new, bodynames=listing, redirects=dict())
    for i in glob('./assets/*/meta.json'):
        with open(i, 'rt', encoding='utf8') as file:
            data = json.loads(file.read())
        if redirects := data.get('redirect'):
            jsonic['redirects'][pathlib.Path(i).parent.name] = redirects
    with open('../assetdata/.assets.json', 'wt', encoding='utf8') as file:
        file.write(json.dumps(jsonic, sort_keys=False))
    pass


def sorter(v):
    bodyname = v[1].get('f-', dict()).get('data', dict()).get('BaseBodyName')
    integer = int(v[0])

    # 'new-phase' still goes first
    is_not_new_phase = -1 if bodyname == 'new-phase' else 0
    to_last = 1 if bodyname is None else 0

    # Fallback None to an empty string so Python doesn't throw a TypeError
    sort_bodyname = bodyname if bodyname is not None else ""

    return is_not_new_phase, to_last, sort_bodyname, integer


def copyfile(src_path, out_path):
    with open(out_path, 'wb') as out, open(src_path, 'rb') as src:
        return out.write(src.read())
    pass


if __name__ == '__main__':
    main()
    input('enter to exit:')
pass
