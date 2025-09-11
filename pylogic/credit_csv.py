#!/usr/bin/env python3
import csv
import pprint
import chardet

print("credit_csv.py")

# 文字コードがutf-8ではない
# {'encoding': 'SHIFT_JIS', 'confidence': 0.2861394557823129, 'language': 'Japanese'}

# with open('data/202506.csv', 'r', encoding="SHIFT_JIS") as f:
with open('data/202506.csv', mode='rb') as f:
    # print(f.read())
    c = f.read()
    result = chardet.detect(c)
    print(result)
    # reader = csv.reader(f)
    # for row in reader:
    #     print(row)


    # >>> chardet.detect(rawdata)
    # print(result)