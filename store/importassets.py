from glob import glob
import pathlib, re


# @lambda _: _()
def main():
    asset_id = 0
    for i in glob('../../dollmaker2/assets/*/*/*/*/metadata.json'):
        if bool(searched := re.search('/([^/]+)/default/([^/]+)/\\d{3}/metadata.json', i.replace('\\', '/'))):
            [legacy, _typeof] = searched.groups()
            if legacy == 'Sticker': continue
            o = f'assets/{str(asset_id).rjust(4, '0')}-f--.svg.php'
            asset_id += 1
            t = pathlib.Path(i).with_name('01.svg.php')
            j = pathlib.Path(o).with_suffix('.metadata.json')
            with (open(i, 'rt', encoding='utf8') as src,
                  open(t, 'rt', encoding='utf8') as svg,
                  open(o, 'wt', encoding='utf8') as out,
                  open(j, 'wt', encoding='utf8') as jso):
                step1 = re.sub(' data-name="[^"]+"', '', svg.read())
                out.write('<svg>')
                # out.write(re.sub('<\\?= "?\\$([a-zA-Z0-9_\\-]+)"? \\?>', 'var(--\\1)', step1))
                out.write(re.sub('"?\\$([a-zA-Z0-9_\\-]+)"?', '"{$GLOBALS[\'\\1\']}"', step1))
                # out.write(step1)
                out.write('</svg>')
                jso.write(src.read())
            pass


pass
