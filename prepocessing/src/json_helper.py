
import json
import random
from my_logging import *

def save_as_json(output, filename="", as_array=True):
    """

    :param output:
    :param filename:
    :return:
    """

    with open(filename, "wb") as fout:
        if as_array:
            fout.write(json.dumps([k for k in output],
                                  separators=(',', ':'),
                                  sort_keys=True, indent=2, ensure_ascii=False).encode('utf8'))
        else:
            fout.write(json.dumps(output,
                                  separators=(',', ':'),
                                  sort_keys=True, indent=2, ensure_ascii=False).encode('utf-8'))




def append_to_json(filename, element, file_dirty):
    """

    :param filename:
    :param element:
    :param file_dirty:
    :return:
    """
    with open(filename, "ab") as fout:
        if file_dirty:
            fout.write(",\n".encode('utf-8'))
        fout.write(json.dumps(element,
                              separators=(',', ':'),
                              sort_keys=True, indent=2, ensure_ascii=False).encode('utf8'))
        return True


def load_jsonlines(filename):
    """
    try to load jsonlines file. if no success load as json
    :param lines:
    :param file_name:
    :return:
    """
    lines = []
    with open(filename, 'r') as fin:
        for line in fin:
            try:
                obj = json.loads(line)
                lines.append(obj)
            except json.decoder.JSONDecodeError as e:
                pass

    if len(lines) == 0 or lines is None:
        return load_json(filename)
    else:
        return lines


def load_json(filename):
    """

    :param filename:
    :return:
    """
    with open(filename, 'r') as fin:
        return json.load(fin)


def jsonlines_to_json(filename):
    """

    :param filename:
    :return:
    """
    save_as_json(load_jsonlines(filename), filename=filename)


def get_n_samples(filename, n):
    """

    :param filename:
    :param n:
    :return:
    """
    data = load_json(filename)
    random.seed(1)
    return random.sample(data, n)


def get_n_samples_gen(filename, n):
    """
    slower, but better if n is very large
    :param filename:
    :param n:
    :return:
    """
    data = load_json(filename)
    random.seed(1)
    for i in range(n):
        yield random.choice(data)


def chunk_json(fin_nam, output_folder, file_number=20):
    """
    helper function to chunk large json-file into smaller portions.
    :param fin_nam:
    :param output_folder:
    :param file_number:
    :return:
    """
    with open(fin_nam, 'r') as fin:
        site_data = json.load(fin)

    num_sites = len(site_data)
    chunk_size = num_sites / file_number
    chunk_nr = 1
    page_id = 0

    while page_id < num_sites:
        temp_chunk = []

        chunk_i = 0

        while chunk_i < chunk_size and page_id < num_sites:
            temp_chunk.append(site_data[page_id])
            chunk_i += 1
            page_id += 1

        save_as_json(temp_chunk,
                     filename=output_folder + fin_nam.split("/")[-1].split("1_zirikly")[0] + str(chunk_nr) + ".json",
                     as_array=True)
        chunk_nr += 1


def make_json_sample(filename, n=3):
    """

    :param filename:
    :param n:
    :return:
    """
    logger.info("\nmake_json_sample")
    sample_file = filename.split(".")[0] + "sample.json"
    file_marker = False
    with json_context_mgnr(sample_file, overwrite=True):
        for element in get_n_samples_gen(filename, n=n):
            file_marker = append_to_json(sample_file, element=element, file_dirty=file_marker)