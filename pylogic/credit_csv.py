#!/usr/bin/env python3
import csv
import pprint
import chardet

# 文字コードがutf-8ではない
# {'encoding': 'SHIFT_JIS', 'confidence': 0.2861394557823129, 'language': 'Japanese'}
# encode = "cp932"
# encode = "utf_8"
encode = "utf-8-sig"
# file_path = 'data/202506.csv'
file_path = 'data/enavi202508(8230).csv'
with open(file_path, 'r', encoding=encode) as f:
# with open('data/202506.csv', mode='rb') as f:
    # # print(f.read())
    # c = f.read()
    # result = chardet.detect(c)
    # print(result)
    reader = csv.reader(f)
    for row in reader:
        print(row)


    # >>> chardet.detect(rawdata)
    # print(result)