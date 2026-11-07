from glob import glob
import pathlib, re


# @lambda _: _()
def main():
    base = pathlib.Path('assets2')
    for i in glob('assets/*'):
        path = pathlib.Path(i)
        numbers = re.sub('\\D', '', path.name)
        (base / numbers / 'f-').mkdir(exist_ok=True, parents=True)
        if path.name.endswith('metadata.json'):
            with open(base / numbers / 'f-' / 'meta.json', 'wb') as out, open(path, 'rb') as src:
                out.write(src.read())
        if path.name.endswith('svg.php'):
            with open(base / numbers / 'f-' / 'main.svg.php', 'wb') as out, open(path, 'rb') as src:
                out.write(src.read())


pass
