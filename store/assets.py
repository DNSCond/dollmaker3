import json, shutil, pathlib, re
from glob import glob


def main():
    array = dict()
    shutil.rmtree('../assetdata')
    pathlib.Path('../assetdata').mkdir(exist_ok=True, parents=True)
    for i in glob('./assets/*/f-/meta.json'):
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
                    out.write(f'<?php\x20require_once\"{{{doc_root}}}/dollmaker3/store/assets/')
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
    with open('../assetdata/.assets.json', 'wt', encoding='utf8') as file:
        file.write(json.dumps(dict(d=array)))
    pass


def copyfile(src_path, out_path):
    with open(out_path, 'wb') as out, open(src_path, 'rb') as src:
        return out.write(src.read())
    pass


if __name__ == '__main__':
    main()
pass
