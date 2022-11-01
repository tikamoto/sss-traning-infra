# これは何 ?

PHPのプログラミング演習のためのDocker環境です。  
以下の開発環境と、演習用のToDoアプリケーションのデザインモックを提供します。
- Apache
- PHP：8.1系
- MySQL：8.0系

# 環境構築

1. `.env.sample`をコピーし`.env`というファイル名で同階層に置く
2. [Docker Desktop](https://www.docker.com/products/docker-desktop/)をインストールし管理者権限で起動 ([※起動時にWSL2のエラーが出たら](https://qiita.com/GalaxyNeko/items/87f4c21e9a4eb386a8b3))
3. ターミナルを管理者権限で起動し、ルートディレクトリ（docker-compose.ymlがある階層）まで移動
4. 以下のコマンドを実行して開発用の仮想環境をビルド
```
docker-compose up -d
```
5. PHPのライブラリの依存関係ファイルをインストール（初回のみ）
```
docker-compose run composer composer install
```
6. [http://web.localhost](http://web.localhost)にアクセスしステータスがすべてOKになっていることを確認

#### ※2回目以降の起動方法
```docker-compose up -d```またはDocker DesktopのGUIから起動

# Adminer（DB管理画面）

1. [http://adminer.localhost](http://adminer.localhost)にアクセスする
2. 以下の情報でログイン

|項目|値|
|:--|:--|
|データベースの種類|MySQL|
|ユーザ名|`.env`の`MYSQL_USER`の値|
|パスワード|`.env`の`MYSQL_PASSWORD`の値|
|データベース|`.env`の`MYSQL_DATABASE`の値|

# Heroku（デプロイ環境）の構築

1. 自身のGithubリポジトリにこのプロジェクト一式をpush
2. [Heroku](https://jp.heroku.com/home)のユーザー登録後、管理画面のCreate New Appからアプリケーションを作成する
3. Deployment methodにGitHubを選択し、Connect to GitHubから1のリポジトリを選択（Connect）
4. Manual deployのDeploy Branchボタンをクリック
5. MySQLのアドオンを追加する<br>Resources → Add-onsの画面で「JawsDB MySQL」と入力して選択
6. Plan nameに「Kitefin Shared - Free」が選択されていることを確認して追加
7. アドオンが追加されたら、SettingのConfig Varsから環境変数を表示
8. JAWSDB_URLという環境変数名で```mysql://<ユーザー>:<パスワード>@<ホスト>:3306/<データベース名>```という値が登録されているので、<br>これを別々の変数名に分けて登録する。

|変数名|値|
|:--|:--|
|DB_HOST|`<ホスト>`の値|
|DB_NAME|`<データベース名>`の値|
|DB_USER|`<ユーザー>`の値|
|DB_PASSWORD|`<パスワード>`の値|

9. `https://<アプリ名>.herokuapp.com/`へアクセスしステータスがすべてOKになっていることを確認

#### ※HerokuのDB管理画面

[http://adminer.localhost](http://adminer.localhost)のログイン画面で上記のホスト、データベース名、ユーザー、パスワードでログインする
 
