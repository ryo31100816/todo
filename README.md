# Todoアプリ

## Ⅰ作成の趣旨
　・PHPを使用した開発に必要な知識の習得

## Ⅱできること
　・Todoリストの作成、編集、削除
　・TodoリストのCSV出力

Ⅱ使用言語・環境
・PHP7.4
・JQuery
・HTML/CSS
・Docker　LEMP環境
・AWS EC2（Ubuntu 18.04）

Ⅲテーブル
　・Users
  +-------------------+--------------+------+-----+---------+----------------+
  | Field             | Type         | Null | Key | Default | Extra          |
  +-------------------+--------------+------+-----+---------+----------------+
  | user_id           | int(11)      | NO   | PRI | NULL    | auto_increment |
  | username          | varchar(45)  | YES  |     | NULL    |                |
  | email             | varchar(45)  | NO   | UNI | NULL    |                |
  | password          | varchar(255) | YES  |     | NULL    |                |
  | created_at        | datetime     | NO   |     | NULL    |                |
  | updated_at        | datetime     | YES  |     | NULL    |                |
  | token             | varchar(255) | YES  |     | NULL    |                |
  | token_registed_at | datetime     | YES  |     | NULL    |                |
  +-------------------+--------------+------+-----+---------+----------------+

　・Todos
  +--------------+--------------+------+-----+---------+----------------+
  | Field        | Type         | Null | Key | Default | Extra          |
  +--------------+--------------+------+-----+---------+----------------+
  | id           | int(11)      | NO   | PRI | NULL    | auto_increment |
  | title        | varchar(255) | NO   |     | 0       |                |
  | detail       | text         | YES  |     | NULL    |                |
  | status       | tinyint(4)   | NO   |     | 0       |                |
  | user_id      | int(11)      | NO   | MUL | NULL    |                |
  | completed_at | datetime     | YES  |     | NULL    |                |
  | created_at   | datetime     | NO   |     | NULL    |                |
  | updated_at   | datetime     | NO   |     | NULL    |                |
  | deleted_at   | datetime     | YES  |     | NULL    |                |
  +--------------+--------------+------+-----+---------+----------------+


Ⅳ実装機能、使用技術
・CRUD機能
・User作成・ログイン・ログアウト機能
・User作成時のメール認証
・CSV抽出機能
・JSによるDOM操作
・Ajaxによる非同期処理
・CSSでのレイアウト作成

Ⅴ力を入れた点
・トークンによるUser認証
　・CSV出力のバックグラウンド実行
