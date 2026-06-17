import json, pathlib
from assets import main

name = input('asset name?:')
asid = input('asset id?:')
orientation = input('asset orientation? (f-):')
with open(pathlib.Path('assets') / f'{str(int(asid)).zfill(4)}-{orientation}-.svg.metadata.json',
          'wt', encoding='utf8') as file:
    file.write(json.dumps({'name': name, 'cost': 50}))
with open(pathlib.Path('assets') / f'{str(int(asid)).zfill(4)}-{orientation}-.svg.php',
          'wt', encoding='utf8') as file:
    file.write('<svg>\n    \n</svg>')
main()
