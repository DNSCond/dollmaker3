from glob import glob
import json, re


def main():
    array = dict()
    for i in glob('./*/*.metadata.json'):
        with open(i, 'rt', encoding='utf8') as file:
            found = re.search('/([^/]+)/([^/]+)\\.metadata\\.json$', i.replace('\\', '/'))
            if found:
                if found.group(1) != 'assets': continue;
                if found.group(1) not in array: array[found.group(1)] = dict()
                array[found.group(1)][found.group(2)] = json.loads(file.read())
    with open('assets.json', 'wt', encoding='utf8') as file:
        file.write(json.dumps(array))


if __name__ == '__main__':
    main()
pass
