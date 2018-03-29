# json_format_compact
json compact formatter

# 概要
JSON(JavaScript Object Notation)は、データをJavaScriptのオブジェクトの表記のように記述できる言語である。  
https://www.json.org/json-ja.html  
その便利さから、多くのプログラミング言語においてインデントや改行などを整形して出力できるライブラリが存在するが、  
例えば `{ "a": [1], "b": [2, 3] }` のような、1行で表現できる簡単なJSONオブジェクトに対しても、
```
{
    "a": [
        1
    ],
    "b": [
        2,
        3
    ]
}
```
のように、必要以上に行数の多い出力がされてしまうことがある。  

そこで、短いオブジェクトは1行で表現し、  
行が長くなる場合には複数行に分けて表現するような整形出力を行うプログラムを作成せよ。  
1行に収める文字数は、実行時のコマンドライン引数として指定される。
```
$ cat sample.json
{ "name": "  espre\"ssivo\"", "attribute": [1, "high", 10], "key": { "innnerKey": [234, 100, 100, 33, 2, 3, 4, 5, 6, 1] } }

$ python json_format.py 30 < sample.json
{
  "name": "  espre\"ssivo\"",
  "attribute": [1, "high", 10],
  "key": {
    "innnerKey": [
      234,
      100,
      100,
      33,
      2,
      3,
      4,
      5,
      6,
      1
    ]
  }
}

$ python json_format.py 50 < sample.json
{
  "name": "  espre\"ssivo\"",
  "attribute": [1, "high", 10],
  "key": {
    "innnerKey": [234, 100, 100, 33, 2, 3, 4, 5, 6, 1]
  }
}
```
