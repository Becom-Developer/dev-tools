# pylogic

dev-tools で利用するロジックを python で作成したい。

作成予定memo

- クレジットカード利用履歴のデータベース化
  - カード会社のcsv形式ファイル取り込み
  - データの成形
  - 成形後のcsvデータ書き出し
  - 成形後データをデータベースに書き込み
- クレジットカード残高照合
  - カード利用履歴の絞り込み検索機能
  - 絞り込み結果をテキストファイル書き出し
  - 絞り込み検索結果の利用履歴をcsv形式でのファイル書き出し
- クレジットカード各社に対応
  - 九州カード(visa)の場合
  - ミライカード(master)の場合
  - 楽天カード(visa)の場合

docker 環境の中で実行

```bash
docker exec -it ctr-dev-tools bash
```

```bash
# 初動の venv 環境準備
python3 -m venv .venv

# (有効化)
source ~/tmp/dev-tools-logic/.venv/bin/activate

# (終了するときは無効化)
(.env) % deactivate

# 仮想環境を使用中にモジュールインストール
(.venv) % python3 -m pip install chardet

# (インストール後は履歴を取っておく)
(venv) % python3 -m pip freeze >> requirements.txt

# (再現インストール)
(venv) % python3 -m pip install -r requirements.txt

# (実行)
(venv) % ./credit_csv.py
```
