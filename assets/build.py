import re
import json
import pathlib
from glob import glob


def main():
    array = list()
    global_ = dict()
    categories = list()
    for i in glob('*/*/*/*/metadata.json'):
        array.append(splitted := i.replace('\\', '/'))
        local = global_
        # for ii in pathlib.Path(i).parent.glob('*.svg.php'):
        #     strx = str(ii)
        #     if not re.search(r'(\d{2})\.svg\.php$', strx):
        #         anomalies.append(strx)
        for [index, objective] in enumerate(replaced := splitted.split('/')):
            if 'metadata.json' == objective:
                continue
            if objective not in local:
                local[objective] = dict()
            local = local[objective]
            if index == 2:
                categories.append(objective)
        with open(splitted, 'rt', encoding='utf8') as file:
            jsonic = json.loads(file.read())
            local['latestVersion'] = jsonic['latestVersion']
            local['name'] = jsonic['name']
            local['cost'] = jsonic.get('cost', 0)
            local['zIndex'] = jsonic.get('zIndex', 0)
            local['private'] = jsonic.get('private', False)
            local['storeReq'] = jsonic.get('storeReq', list())
            local['requirements'] = jsonic.get('requirements', list())
            local['incompatibleWidth'] = jsonic.get('incompatibleWidth', list())
            anomalies = dict()
            for ii in pathlib.Path(i).parent.glob('*.svg.php'):
                strx = str(ii).replace('\\', '/')
                if bool(matched := re.search(r'(\d{2})-([a-zA-Z0-9\-]+)\.svg\.php$', strx)):
                    if matched.group(1) not in anomalies:
                        anomalies[matched.group(1)] = [matched.group(2)]
                    else:
                        anomalies[matched.group(1)].append(matched.group(2))
            jsonic['anomalies'] = anomalies
            local['anomalies'] = anomalies
        with open(splitted, 'wt', encoding='utf8') as file:
            file.write(json.dumps(jsonic))
    with open('assets.json', 'wt', encoding='utf8') as file:
        mydict = dict(
            # array=array,
            categories=categories,
        )
        # noinspection PyTypeChecker
        mydict['global'] = global_
        file.write(json.dumps(mydict))
    pass


if __name__ == '__main__':
    main()

pass
