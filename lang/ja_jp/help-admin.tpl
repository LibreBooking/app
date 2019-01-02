{* -*-coding:utf-8-*-
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl'}
<h1 xmlns="http://www.w3.org/1999/html">Booked Scheduler 管理</h1>

<div id="help">
<h2>管理</h2>

<p>
アプリケーション管理者のロール(役割)のユーザーには、メニューに「管理」の項目が表示されます。
管理操作はこの中にあります。
</p>

<h3>スケジュールの設定</h3>

<p>
Booked Scheduler をインストールするとき、何もしなくてもデフォルトスケジュールが作成されます。
メニューの「スケジュール」から現在操作対象になっているスケジュールの属性を表示し変更することできます。
</p>

<p>
それぞれのスケジュールでは、時間枠を個々に定義しておかなくてはなりません。
時間枠は各スケジュール中のリソースの稼働性を決めるものです。
「時間枠の変更」をクリックすると時間枠エディターが表示されます。
ここで予約の時間区分を作成し、予約可能か予約不能かに分けます。
時間区分をどう分けるかは自由ですが、1日(24時間)のすべての時間を網羅するようにしなくてはなりません。
一行に一つの時間区分を書きます。
時刻の表記は24時間制です。
時間区分に任意で表示ラベルを付けることも出来ます。
</p>

<p>ラベルの無い時間区分は次のように書きます。10:25 - 16:50</p>

<p>ラベルを付ける場合は次のように書きます。10:25 - 16:50 Schedule Period 4</p>

<p>
時間区分設定ウィンドウの下は、支援ツールになっています。
開始時刻から終了時刻までを指定の間隔で分割し、時間区分を作り出します。
</p>

<h3>リソースの設定</h3>

<p>
リソースの表示と管理は、メニューの「リソース」から行います。
リソースの属性や運用規則を変更することができます。
</p>

<p>Booked Scheduler での「リソース」とは、部屋や設備のような予約制にしたいあらゆるもののことです。
リソースを予約制にするために、適したスケジュールに割り当ててください。
リソースはスケジュールの時間枠をそのまま使用します。
</p>

<p>最小予約時間を設定すると、それより短い予約は作成できなくなります。
デフォルトでの制限はありません。
</p>

<p>最大予約時間を設定すると、それより長い予約は作成できなくなります。
デフォルトでの制限はありません。
</p>

<p>リソースを承認が必要であると設定すると、作成した予約は承認されるまで保留状態になります。
デフォルトでは承認は不要です。
</p>

<p>リソースを「自動的に許可される」ように設定しておくと、新しいユーザーは登録時にそのリソースを予約できるようになります。
デフォルトは自動的に許可されるようになっています。
</p>

<p>日/時/分きざみで、予約にリードタイム(先行時間)を設定することができます。
例えば、月曜の10:30 AMからの予約を取りたいとし、予約には1日前に告知が必要であるとします。
この場合、日曜の10:30 AM以後は予約できません。
デフォルトでは、現在時刻まで予約することができます。
</p>

<p>日/時/分まで指定してきざみで時間を指定して、はるか未来の予約を禁止できます。
例えば、今が月曜の10:30 AMだとし、リソースでは予約の終了時刻を1日以上先にすることができない設定にしてあるとします。
この場合、(終わりが)火曜の10:30 AMを過ぎる予約は出来ません。
デフォルトでは、制限はありません。
</p>

<p>時にはリソースの定員が足りないことがあります。
例えば、8人しか入れないカンファレンスルームもあります。
リソースの定員を設定すれば、主催者を除く参加者数をそれ以内に抑えることができます。
デフォルトは無制限です。
</p>

<p>アプリケーション管理者は定員の制限を受けません。</p>

<h3>リソースの画像</h3>

<p>予約ページでリソースの詳細を見るときに表示されるリソースの画像を設定することができます。
そのためには php_gd2 がインストールされ php.ini で有効になっていなくてなりません。
<a href="http://www.php.net/manual/en/book.image.php">詳細はこちら</a>
</p>

<h3>備品の設定</h3>

<p>このシステムでいう「備品」とは予約時間中に使用する物品のことと考えてかまいません。
例えば、カンファレンスルームで使うプロジェクターや椅子です。
</p>

<p>備品はメニューの「備品」から表示し操作することができます。
設定されている備品の数量を超えて、同時に予約することはできません。
</p>

<h3>予約量を制限する</h3>

<p>限度を設定し、予約できる量を制限することができます。
Booked Scheduler の量制限システムは柔軟にできていて、予約時間と回数で制限をかけることができます。
また、量制限は「重なり」ます。
1日に5時間までという制限があり、さらに1日に4回までという制限もあるとします。
ユーザーは4時間の予約を取ることはできますが、2時間の予約を3つは取れません。
これらを組み合わせて強力な制限を行うことができます。</p>

<p>アプリケーション管理者は予約量の制限を受けません。</p>

<h3>お知らせの設定</h3>

<p>お知らせは Booked Scheduler のユーザーに注意事項を知らせる簡単な方法です。
メニューの「お知らせ」から、ユーザーのダッシュボードに表示されるお知らせを、管理することができます。
お知らせにはオプションとして開始日と終了日があります。
また任意で優先度を付けることができ、1から10の順に並べ替えて表示します。</p>

<p>お知らせのテキストではHTMLを使うことができ、リンクや画像を埋め込むことができます。</p>

<h3>グループの設定</h3>

<p>Booked Scheduler でのグループはユーザーを組織化し、リソース使用の可否を決定し、アプリケーション内での役割を定めます。</p>

<h3>役割</h3>

<p>役割はユーザーのグループに特定の操作を行う権限を与えます。</p>

<p>アプリケーション管理者(Application Administrator): この役割を与えられたグループのユーザーは、管理特権を行使することができます。この役割はリソースを予約するのにほとんど制限を受けません。アプリケーションのあらゆる箇所を管理できます。</p>

<p>グループ管理者(Group Administrator): この役割を与えられたグループのユーザーは、グループのユーザーの代理で予約を行うことができ、ユーザーを管理することができます。</p>

<p>リソース管理者(Resource Administrator): この役割を与えられたグループのユーザーは、リソースの管理と、そのリソースの予約を承認することができます。</p>

<p>スケジュール管理者(Schedule Administrator): この役割を与えられたグループのユーザーは、スケジュールとそこに割り当てられたリソースの管理および予約の承認を行うことができます。</p>

<!-- Viewing and Managing Reservations -->
<h3>予約の表示と管理</h3>

<p>メニューの「予約」で予約の表示と管理を行うことができます。
デフォルトの設定では今日の前後7日間の予約が表示されます。
見つけたいものによって粒度を大きくも小さくもできます。
このツールで予約の様子をすばやく見ることができます。
また予約のリストをCSV形式で出力することができます。</p>

<!-- Reservation Approval -->
<h3>予約の承認</h3>

<p>$conf['settings']['reservation']['updates.require.approval'] を true に設定すると、すべての予約リクエストは一旦保留された状態になります。
予約は、管理者が承認して、始めて有効になります。
管理者は予約管理ツールで承認保留中の予約を表示し承認することができます。
保留中の予約はハイライト表示されています。</p>

<!-- Viewing and Managing Users -->
<h3>ユーザーの表示と管理</h3>

<p>メニューの「ユーザー」から、ユーザーを登録したりユーザーを一覧することができます。
このツールでは次のようなことができます。
ユーザー個々にリソースの使用権限を変更する。
アカウントを使用不能にしたり削除する。
ユーザーパスワードをリセットする。
ユーザー情報の詳細を編集する。
新規ユーザーを追加するのもここです。
ユーザー自身での登録を無効にしている場合、この機能は無くてはならないものでしょう。</p>

<!-- Reporting -->
<h3>レポート作成</h3>

<p>全てのアプリケーション管理者、グループ管理者、リソース管理者、スケジュール管理者はレポートを利用できます。レポート機能を利用できるユーザーとしてログイン中であれば、メニューにレポートが表示されます。
Booked Scheduler では予め汎用のレポートを用意しており、リストや図として表示すること、CSVとして出力すること、印刷することができます。
それらに加えてメニューの「新しいレポートを作る」からその場でレポートを作成することができます。このレポートもリスト表示、図表示、出力、印刷が可能です。
さらに自作のレポートを保存しておき、メニューの「保存されたレポート」から呼び出すことができます。レポート結果をメールで送信することもできます。
</p>

<!-- Reservation Reminders -->
<h3>予約のリマインダー</h3>

<p>予約の開始時刻または終了時刻にに先立ってリマインダーメールを受け取れるように出来ます。
この機能を有効にするには $conf['settings']['enable.email'] および $conf['settings']['reservation']['enable.reminders'] の両方を true にしなくてはなりません。
更に、サーバーのスケジュールタスクが /Booked Scheduler/Jobs/sendreminders.php を実行するようにしなくてはなりません。</p>

<p>Linux の場合は cron ジョブを使えるでしょう。実行するコマンドは <span class="note">php</span> の後ろに
Booked Scheduler/Jobs/sendreminders.php のフルパスを付けたものです。このサーバーの sendreminders.php へのフルパスは
 <span class="note">{$RemindersPath}</span> です。
</p>

<p>見本としてですが、次のようになるでしょう。 <span class="note">* * * * * php {$RemindersPath}</span></p>

<p>ホスティングサービスを使っていて cPanel が使用できるなら <a href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">
cPanelで cron ジョブを設定する方法</a> が近道です。「Common Settings」メニューから「Every Minute(毎分)」を選択するか、
minute(分)、hour(時)、day(日)、month(月)、weekday(曜日)のすべてを * にしてください。.</p>

<p>Windows の場合は <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">
タスクスケジューラを使う</a>ことが出来るでしょう。 タスクは毎分実行されるようにしなくてはなりません。実行するタスクは php の後ろに
Booked Scheduler/Jobs/sendreminders.php のフルパスを指定したものです。</p>

<!-- Configuration -->
<h2>アプリケーション設定</h2>

<p>一部の機能は設定ファイルを編集して設定するしかありません。</p>

<p class="setting"><span>$conf['settings']['default.timezone']</span>デフォルトで使用するタイムゾーン。
設定されなければサーバーのタイムゾーンを使用する。
設定できる値は次のリンクにある。: <a href="http://php.net/manual/en/timezones.php" target="_blank">http://php.net/manual/en/timezones.php</a></p>

<p class="setting"><span>$conf['settings']['allow.self.registration']</span>ユーザー自身でアカウントを作成できるか否か</p>

<p class="setting"><span>$conf['settings']['admin.email']</span>アプリケーション管理者のメールアドレス</p>

<p class="setting"><span>$conf['settings']['default.page.size']</span>データのリストを表示する際のページあたりの表示数の初期値</p>

<p class="setting"><span>$conf['settings']['enable.email']</span>Booked Scheduler がメールを送信するか否か</p>

<p class="setting"><span>$conf['settings']['default.language']</span>ユーザーのデフォルトの言語。Booked Scheduler のlangディレクトリにある言語ならどれでも可</p>

<p class="setting"><span>$conf['settings']['script.url']</span>Booked Scheduler インスタンスのルートへの完全な公開URL。
これはbookings.php、calendar.phpのようなファイルを含んでいるWebという名のディレクトリがあるので、それにしておくこと。
この値が // で始まる場合、プロトコル(httpかhttpsか)は自動的に検出される。</p>

<p class="setting"><span>$conf['settings']['image.upload.directory']</span>画像を保存する物理的なディレクトリのパス。
このディレクトリに書き込みできる(755とか)必要がある。この指定は完全ディレクトリ名(フルパス)またはBooked Schedulerのルートディレクトリからの相対パスのいずれでもよい。</p>

<p class="setting"><span>$conf['settings']['image.upload.url']</span>そこにアップロードされた画像を表示することができるディレクトリのURL。完全なURLまたは$conf['settings']['script.url']からの相対URLのいずれでもよい。</p>

<p class="setting"><span>$conf['settings']['cache.templates']</span>テンプレートをキャッシュするか否か。tpl_cが書き込み可能なら、trueにすることが推奨される。</p>

<p class="setting"><span>$conf['settings']['use.local.jquery']</span>jQueryファイルをローカルサーバーにあるものを使うようにするかどうか。falseにするとGoogle CDNにあるものを使うようになる。パフォーマンスや転送帯域の観点からfalseにすることを推奨。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>ユーザーアカウントの登録時にキャプッチャを使うか否か</p>

<p class="setting"><span>$conf['settings']['registration.require.email.activation']</span>ユーザーは最初にログインする前にメールでアカウントの有効化をする必要があるかどうか。</p>

<p class="setting"><span>$conf['settings']['registration.auto.subscribe.email']</span>ユーザーを登録する際に、各種通知メールを受け取るように設定するかどうか。</p>

<p class="setting"><span>$conf['settings']['inactivity.timeout']</span>ユーザーが自動的にログアウトするまでの時間を分で指定する。自動ログアウトを無効にしたいときは空文字列にすること。</p>

<p class="setting"><span>$conf['settings']['name.format']</span>first name、last nameの表示フォーマット。デフォルトは {literal}'{first} {last}'{/literal}。</p>

<p class="setting"><span>$conf['settings']['css.extension.file']</span>追加でインクルードするCSSファイルの完全または相対URL。
これはデフォルトのスタイルを上書きするために使うことができ、完全なテーマとして使用することもできる。 Booked Schedulerのスタイルを拡張しないなら空白のままにしておく。</p>

<p class="setting"><span>$conf['settings']['disable.password.reset']</span>パスワードリセット機能を無効化するかどうか。
	デフォルトは false.</p>

<p class="setting"><span>$conf['settings']['home.url']</span>ロゴをクリックした際に、移動するページのURL。
	デフォルトはユーザーのホームページ。</p>

<p class="setting"><span>$conf['settings']['logout.url']</span>ログアウト後にユーザーが移動するページ。
	デフォルトはログインページ。</p>

<p class="setting"><span>$conf['settings']['schedule']['use.per.user.colors']</span>予約の表示色を管理者がユーザー毎に設定できるか否か。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>ユーザーが予約できないリソースをスケジュール中に表示するか否か</p>

<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>予約状況ページで各予約に表示する値。
{literal}{name}, {title}, {description}, {email},{phone}, {organization}, {position}{/literal}が使用可能。
組み合わせて使用することができる。何も表示したくない場合は空白のままにする。</p>

<p class="setting"><span>$conf['settings']['schedule']['hide.blocked.periods']</span>予約できない時間帯を予約ページに表示しない。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['ics']['require.login']</span>予約をOutlookへ追加するのにログインする必要があるかどうか。</p>

<p class="setting"><span>$conf['settings']['ics']['subscription.key']</span>webcalによる購読を有効にしたいなら、推測困難な文字列を設定する。何も設定されていなければwebcalによる購読は無効。</p>

<p class="setting"><span>$conf['settings']['privacy']['view.schedules']</span>認証されていないユーザーが予約状況を見ることができるかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['privacy']['view.reservations']</span>認証されていないユーザーが予約の詳細を見ることができるかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['privacy']['hide.user.details']</span>管理者でなくても他のユーザーの情報を見ることができるかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation']['start.time.constraint']</span>
予約を作成したり編集したりできるタイミング。設定できるのは future、current、none。
future にすると、まだ、選択した予約(時間の)枠の開始時刻になっていなければ、作成、変更できる。
current にすると、まだ、選択した予約(時間の)枠の終了時刻になっていなければ、作成、変更できる。
none にすると予約の作成、変更に現在時刻による制限はない。
デフォルトは future。</p>

<p class="setting"><span>$conf['settings']['reservation']['updates.require.approval']</span>承認が必要であった予約を変更する際に、再度承認が必要かどうか。デフォルトは false.</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.participation']</span>ユーザーが別のユーザーを予約の参加者にしたり招待する機能を使えないようにするかどうか。デフォルトは false (なので有効)。</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.recurrence']</span>繰り返し予約する機能を使えないようにするかどうか。デフォルトは false (なので有効)。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>予約が作成されたとき、全てのリソース管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>予約が更新されたとき、全てのリソース管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>予約が削除されたとき、全てのリソース管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>予約が作成されたとき、全てのアプリケーション管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>予約が更新されたとき、全てのアプリケーション管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>予約が削除されたとき、全てのアプリケーション管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>予約が作成されたとき、全てのグループ管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>予約が更新されたとき、全てのグループ管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>予約が削除されたとき、全てのグループ管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['uploads']['enable.reservation.attachments']</span>ユーザーが予約にファイルを添付できるかどうか。デフォルトはfalse 。</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.path']</span>添付ファイルを保存するディレクトリのファイルシステム上の絶対または(Booked Scheduler ディレクトリのルートからの)相対パス。ディレクトリにPHPが書き込み可能(755とか)でなくてはならない。デフォルトは uploads/reservation</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>安全とみなすファイル拡張子のカンマで区切ったリスト。空白にすれば全てのファイル拡張子がアップロードできる。(推奨しない)</p>

<p class="setting"><span>$conf['settings']['database']['type']</span>PEAR::MDB2 でサポートされている型の何れか</p>

<p class="setting"><span>$conf['settings']['database']['user']</span>データベースにアクセスするユーザー</p>

<p class="setting"><span>$conf['settings']['database']['password']</span>データベースユーザーのパスワード</p>

<p class="setting"><span>$conf['settings']['database']['hostspec']</span>データベースホストのURLまたは名前付きパイプ</p>

<p class="setting"><span>$conf['settings']['database']['name']</span>Booked Scheduler 使うデータベース名</p>

<p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>PHPのメールライブラリ。mail、smtp、sendmail、qmail から選ぶ</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>smtp を使う場合の SMTPホスト</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.port']</span>smtp を使う場合の SMTPポート。通常は25</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.secure']</span>smtp を使う場合の SMTP セキュリティ。''(空文字列)、ssl 、tls のいずれか</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.auth']</span>smtp を使う場合に SMTP 認証が必要かどうか。true または false</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.username']</span>smtp を使う場合の SMTP ユーザー名</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.password']</span>smtp を使う場合の SMTP パスワード</p>

<p class="setting"><span>$conf['settings']['phpmailer']['sendmail.path']</span>sendmail コマンドを使う場合の sendmail コマンドのパス</p>

<p class="setting"><span>$conf['settings']['plugins']['Authentication']</span>使用する認証(authentication)プラグインの名称。詳しくは下記のプラグインの項で。</p>

<p class="setting"><span>$conf['settings']['plugins']['Authorization']</span>使用する権限(authorization)プラグインの名称。詳しくは下記のプラグインの項で。</p>

<p class="setting"><span>$conf['settings']['plugins']['Permission']</span>使用する許可(permission)プラグインの名称。詳しくは下記のプラグインの項で。</p>

<p class="setting"><span>$conf['settings']['plugins']['PreReservation']</span>使用する予約前実行(prereservation)プラグインの名称。詳しくは下記のプラグインの項で。</p>

<p class="setting"><span>$conf['settings']['plugins']['PostReservation']</span>使用する予約後実行(postreservation)プラグインの名称。詳しくは下記のプラグインの項で。</p>

<p class="setting"><span>$conf['settings']['install.password']</span>インストールもしくはアップグレードを実行しようとするとき、何かパスワードを設定しておく必要がある。</p>

<p class="setting"><span>$conf['settings']['pages']['enable.configuration']</span>アプリケーション管理者に設定を変更するページを表示するかどうか。true または false。</p>

<p class="setting"><span>$conf['settings']['api']['enabled']</span>Booked Scheduler で RESTful API を有効にするかどうか。
このAPIの使用環境については readme_installation.html を見ること。true または false。</p>

<p class="setting"><span>$conf['settings']['recaptcha']['enabled']</span>組み込みのキャプッチャではなく reCAPTCHA を使うかどうか。true または false。</p>

<p class="setting"><span>$conf['settings']['recaptcha']['public.key']</span>reCAPTCHA の公開鍵(public key)。
サインアップするには www.google.com/recaptcha へ行く。</p>

<p class="setting"><span>$conf['settings']['recaptcha']['private.key']</span>reCAPTCHA の秘密鍵(private key)。サインアップするには www.google.com/recaptcha へ行く。</p>

<p class="setting"><span>$config['settings']['email']['default.from.address']</span>
メールを送信する際の 'from' アドレスとして使われるメールアドレス。
メールがバウンス(エラーで返される)したりスパムと判定されてしまうときは自身のドメインをメールアドレスに設定しましょう。
例えば、noreply@yourdomain.com。
これは 'from' 名、reply-toアドレスは変更しない。</p>

<p class="setting"><span>$conf['settings']['reports']['allow.all.users']</span>管理者以外のユーザーがレポート画面を操作できるかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['password']['minimum.letters']</span>ユーザーパスワードの最少の長さ。デフォルトは 6。</p>

<p class="setting"><span>$conf['settings']['password']['minimum.numbers']</span>ユーザーパスワード中に必須の数字の数。デフォルトは 0。</p>

<p class="setting"><span>$conf['settings']['password']['upper.and.lower']</span>ユーザーパスワードに大文字と小文字の両方が必要かどうか。デフォルトは false。</p>

<h2>プラグイン</h2>

<p>下記のコンポーネントがプラグイン可能になっています:</p>

<ul>
	<li>Authentication - 誰がログインできるか</li>
	<li>Authorization - ログインしたとき何ができるか</li>
	<li>Permission - ユーザーはどのリソースを使うことができるか</li>
	<li>Pre Reservation - 予約を作成する直前に何を実行するか</li>
	<li>Post Reservation - 予約を作成した直後に何を実行するか</li>
</ul>

<p>プラグインを有効にするには、プラグインフォルダの名前を設定ファイルに書きます。
例えば、LDAP認証を有効にするには、次の設定を記述します。
$conf['settings']['plugins']['Authentication'] = 'Ldap';
</p>

<p>プラグインにはそれぞれの設定ファイルがあります。
LDAPの場合は、/plugins/Authentication/Ldap/Ldap.config.dist を/plugins/Authentication/Ldap/Ldap.configにリネームするかコピーし、すべての値を実行環境に合わせて編集します。
</p>

<h3>プラグインのインストール</h3>

<p>新しいプラグインをインストールするにはそれのフォルダをAuthentication、Authorization、Permissionディレクトリのいずれかにコピーします。
そしてconfig.php の $conf['settings']['plugins']['Authentication']、$conf['settings']['plugins']['Authorization'] 、$conf['settings']['plugins']['Permission'] のいずれかの値をフォルダの名前に変更します。
</p>

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}