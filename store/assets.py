from glob import glob
import json, re


def main():
    array = dict()
    for i in glob('./*/*.metadata.json'):
        with open(i, 'rt', encoding='utf8') as file:
            found = re.search('/([^/]+)/([^/]+)\\.metadata\\.json$', i.replace('\\', '/'))
            if found:
                if found.group(1) != 'assets': continue;
                data = json.loads(file.read())
                if data.get('private'): continue;
                if found.group(1) not in array: array[found.group(1)] = dict()
                array[found.group(1)][found.group(2)] = data
    with open('assets.json', 'wt', encoding='utf8') as file:
        file.write(json.dumps(array))
    with open('assets-random.json', 'wt', encoding='utf8') as file:
        randarray = dict()
        for current_id, value in array['assets'].items():
            base_body = value.get('baseBody')
            if base_body:
                searched = re.search('^(\\d+)', current_id)
                if searched:
                    if randarray.get(base_body) is None:
                        randarray[base_body] = list()
                        if base_body == int(searched.group(1)): continue
                    randarray[base_body].append(int(searched.group(1)))
        file.write(json.dumps(randarray))


if __name__ == '__main__':
    main()
pass
