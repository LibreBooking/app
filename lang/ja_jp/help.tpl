{* -*-coding:utf-8-*-
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl'}
<h1>phpScheduleIt Help</h1>

<div id="help">
<h2>ユーザー登録</h2>

<p>
管理者(あなた)が設定していれば、phpScheduleItを使うためにユーザー登録が必要です。
アカウント登録後はログインできるようになり、許可されているリソースの予約ができるようになります。
</p>

<h2>予約</h2>

<p>
メニューの「スケジュール」の中に、予約状況という項目があります。
ここで予約状況や使用不能な時間を確認することができ、許可されているリソースは予約することができます。
</p>

<h3>エクスプレス</h3>

<p>
予約ページで、予約したいリソースと日時を探してください。
時間枠をクリックすれば予約の詳細を変更することができます。
「作成」ボタンは同じじかんに他の予約があるかどうかをチェックし、問題なければ予約を取り、メールを送信します。
後で予約を確認したりするための照会番号が発行されます。
</p>

<p>予約を変更する場合、かならず保存操作をしてください。そうしないと変更が反映されません。</p>

<p>アプリケーション管理者だけは過去の時間の予約を作成することができます。</p>

<h3>複数のリソース</h3>

<p>
一件の予約で、複数のリソースを一度に確保することができます。
複数のリソースを追加したいときは「別のリソースも」リンクをクリックしリソースを表示させます。
そこで追加したいリソースを選択し「決定」ボタンをクリックします。
</p>

<p>
予約から追加のリソースを外したいときは「別のリソースも」リンクをクリックし、外したいリソースの選択を解除し「決定」をクリックします。
</p>

<p>
追加のリソースは最初のリソースと同じ予約ルールが適用されます。例をあげて説明すると、リソース1(最長3時間まで予約できる)とリソース2(1時間しか予約できない)を2時間予約しようとしても、予約は取れないという意味です。
</p>

<p>リソース名にマウスカーソルを重ねるとリソースの詳細な設定(運用規則)を見ることができます。</p>

<h3>繰り返し</h3>

<p>
様々な方法で予約を繰り返して指定することができます。
いずれの繰り返しでも「～まで(Until)」はその日も期間に含みます。
</p>

<p>
繰り返しのオプションは柔軟な設定ができるようになっており、次のような指定ができます。
「日を単位に」を選び毎「2」日を指定すると、指定日まで1日おきの予約を作成します。
「週を単位に」を選び毎「1」週を指定し、『この曜日に』で 「月 水 金」を選ぶと、指定した日までそれぞれの曜日に予約を作成します。
仮に2011年1月15日の予約を作成しているとします。
繰り返しで「月を単位に」を選び、毎「3」か月、「同じ日付」を選ぶと、3か月ごとの15日に予約を作成します。
「同じ曜日」を選んでいたら、2011年1月15日は1月の第3土曜日ですので、3か月ごとの第3土曜日に予約を作成します。
</p>

<h3>出席者の追加</h3>

<p>
予約を取る際に、他のユーザーを出席者もしくは招待者として登録することが出来ます。
出席者として登録されると、そのユーザーは出席者リストに入り招待メールは送信されませんが、通知メールが送
信されます。
招待者として登録されると、そのユーザーには招待メールが送信され受理するか辞退するかを選んでもらいます。
ユーザーが受理すれば出席者リストに入り、辞退すれば招待者リストから消えます。
</p>

<p>
出席者数の上限は、リソースの定員までです。
</p>

<h3>備品</h3>

<p>
このシステムでいう「備品」とは予約時間中に使用する物品のことと考えてかまいません。
例えば、プロジェクターや椅子です。
予約の備品を追加するには、備品名称の右にあるリンクをクリックします。
そこから使用できる備品の数量を選ぶことできます。
すでに予約されている数量によって、同じ時間に使える数が変わります。
</p>

<h3>代理での予約</h3>

<p>アプリケーション管理者およびグループ管理者は他のユーザーの名義で予約を行うことができます。
予約作成時にユーザー名の右の「変更」リンクをクリックします。</p>

<p>アプリケーション管理者およびグループ管理者は、他のユーザーの予約を変更したり削除することができます。</p>

<h2>予約の更新</h2>

<p>自分で作成した予約は(自分名義のものを含め)、自身で更新することができます。</p>

<h3>繰り返して作成した予約の一部修正</h3>

<p>
予約を作成する際に繰り返しを指定すると、一連の予約が作成されます。
そのような予約を訂正・更新しようとすると、どの予約について変更するのかを尋ねられます。
そのとき表示している予約だけ(「この予約だけ」)を変更し、残りはそのままにしておくことができます。
一連の予約すべて(の未だ過ぎていないもの)を変更することもできます。
その予約から先の分だけに適用を選ぶこともでき、そうすると表示している予約を含めて、その先の予約を変更することになります。
</p>

<p>アプリケーション管理者だけが、過去の予約を変更することができます。</p>

<h2>予約の削除</h2>

<p>予約を削除すると、スケジュールから完全に取り除かれます。phpScheduleItのどこからも見えなくなります</p>

<h3>一連の予約から特定のものを削除する</h3>

<p>予約の更新と同じように削除時にも、どれを消すかを選ぶことができます。</p>

<p>過去の予約を削除することができるのはアプリケーション管理者だけです。</p>

<h2>カレンダーアプリ(Outlook&reg;、iClal、Mozilla Lightning、Evolution)に予約を追加する</h2>

<p>
予約の表示、更新の際に「Outlookへ追加」ボタンがあるのが分かると思います。
お使いのコンピューターにOutlookがインストールされていれば、ミーティングを追加するかどうか尋ねられることでしょう。
インストールされていない場合は .iscファイルをダウンロードするかどうか尋ねられることになるでしょう。
これはカレンダーアプリの標準的なフォーマットです。
iCalendarファイル形式をサポートしているアプリケーションで使用できます。
</p>
<h2>カレンダーの購読 Subscribing to Calendars</h2>

<p>スケジュール、リソース、ユーザーのカレンダーを公開することができます。
この機能を有効にするには、管理者が設定ファイル中で購読キーワード(subscription key)を設定しなくてはなりません。
スケジュールまたはリソースのカレンダーを購読できるようにするには、そのスケジュールまたはリソースを管理する際に機能をオンにするだけです。
個人のカレンダーを購読できるようにするには「スケジュール」→「マイカレンダー」を開きます。
ページの右側にカレンダーの購読を「許可する」または「禁止する」というリンクがあります。
</p>

<p>スケジュールのカレンダーを購読するには「スケジュール」→「リソースカレンダー」を開き、 希望のスケジュールを選びます。
ページの右側にカレンダーを購読するリンクがあります。
リソースのカレンダーを購読するのも同じ手順です。
あなたの個人カレンダーを購読するには「スケジュール」→「マイカレンダー」を開きます。
ページの右側に、カレンダーを購読するリンクがあります。
</p>

<h3>カレンダークライアント(Outlook&reg;、iClal、Mozilla Lightning、Evolution)</h3>

<p>たいていは「このカレンダーを購読する」をクリックするだけでカレンダークライアントでの購読が、自動的にセットアップされます。
Outlookでカレンダー購読が自動的に追加されない場合、カレンダービューを開いてください。
マイカレンダー(My Calendars)を右クリックし「カレンダーを追加」→「インターネットから」を選択します。
phpScheduleItの「カレンダーを購読する」リンクの下に表示されているURLをペーストします。
</p>

<h3>Google&reg; Calendar</h3>

<p>Googleカレンダーの設定を開きます。
カレンダータブをクリックします。
「他のカレンダー」をクリックします。
「URLで追加」をクリックします。
phpScheduleItの「カレンダーを購読する」リンクの下に表示されているURLをペーストします。
</p>

<h2>予約量の制限</h2>

<p>
管理者は色々な条件を使って、予約できる量を制限することができます。
この量制限に違反するような予約は注意を受け、拒否されます。
</p>

<h2>管理</h2>

<p>
アプリケーション管理者のロール(役割)のユーザーには、メニューに「管理」の項目が表示されます。
管理操作はこの中にあります。
</p>

<h3>スケジュールの設定</h3>

<p>
phsScheduleitをインストールするとき、何もしなくてもデフォルトスケジュールが作成されます。
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

<p>ラベルなしの時間区分は次のように書きます。10:25 - 16:50</p>

<p>ラベルを付ける場合は次のように書きます。10:25 - 16:50  Schedule Period 4</p>

<p>
時間区分設定ウィンドウの下は、支援ツールになっています。
開始時刻から終了時刻までを指定の時間で分割し、時間区分を作り出します。
</p>

<h3>リソースの設定</h3>

<p>
リソースの表示と管理は、メニューの「リソース」から行います。
リソースの属性や運用規則を変更することができます。
</p>

<p>
phpScheduleItでの「リソース」とは、部屋や設備のような予約制にしたいあらゆるもののことです。
リソースを予約制にするために、適したスケジュールに割り当ててください。
リソースはスケジュールの時間枠をそのまま使用します。
</p>

<p>
最小予約時間を設定すると、それより短い予約は作成できなくなります。
デフォルトでの制限はありません。
</p>

<p>
最大予約時間を設定すると、それより長い予約は作成できなくなります。
デフォルトでの制限はありません。
</p>

<p>
リソースを承認が必要であると設定すると、作成した予約は承認されるまで保留状態になります。
デフォルトでは承認は不要です。
</p>

<p>
リソースを「自動的に許可される」ように設定しておくと、新しいユーザーは登録時にそのリソースを予約できるようになります。
デフォルトは自動的に許可されるようになっています。
</p>

<p>
日/時/分きざみで、予約にリードタイム(先行時間)を設定することができます。
例えば、月曜の10:30 AMからの予約を取りたいとし、予約には1日前に告知が必要であるとします。
この場合、日曜の10:30 AM以後は予約できません。
デフォルトでは、現在時刻まで予約することができます。
</p>

<p>
日/時/分きざみで時間を指定して、はるか未来の予約を禁止できます。
例えば、今が月曜の10:30 AMだとし、リソースでは予約の終了時刻を1日以上先にすることができない設定であるとします。
この場合、(終わりが)火曜の10:30 AMを過ぎる予約は出来ません。
デフォルトでは、制限はありません。
</p>

<p>
時にはリソースの定員が足りないことがあります。
例えば、8人しか入れないカンファレンスルームもあります。
リソースの定員を設定すれば、主催者を除く参加者数をそれ以内に抑えることができます。
デフォルトは無制限です。
</p>

<p>アプリケーション管理者は定員の制限を受けません。</p>

<h3>リソースの画像</h3>

<p>
予約ページでリソースの詳細を見るときに表示されるリソースの画像を設定することができます。
そのためには php_gd2 がインストールされ php.ini で有効になっていなくてなりません。
<a href="http://www.php.net/manual/en/book.image.php">詳細はこちら</a>
</p>

<h3>備品の設定</h3>

<p>
このシステムでいう「備品」とは予約時間中に使用する物品のことと考えてかまいません。
例えば、カンファレンスルームで使うプロジェクターや椅子です。
</p>

<p>
備品はメニューの「備品」から表示し操作することができます。
設定されている備品の数量を超えて、同時に予約することはできません。
</p>

<h3>予約量を制限する</h3>

<p>
限度を設定し、予約できる量を制限することができます。
phpScheduleItの量制限システムは柔軟にできていて、予約時間と回数で制限をかけることができます。
また、量制限は「重なり」ます。
1日に5時間までという制限があり、また1日に4回までという制限もあるとします。
ユーザーは4時間の予約を取ることはできますが、2時間の予約を3つは取れません。
組み合わせて強力な制限を行うことができます。
</p>

<p>アプリケーション管理者は予約量の制限を受けません。</p>

<h3>お知らせの設定</h3>

<p>
お知らせはphpScheduleItのユーザーに注意事項を知らせる簡単な方法です。
メニューの「お知らせ」から、ユーザーのダッシュボードに表示されるお知らせを、管理することができます。
お知らせにはオプションとして開始日と終了日があります。
また任意で優先度を付けることができ、1から10の順に並べ替えて表示します。
</p>

<p>お知らせのテキストではHTMLを使うことができ、リンクや画像を埋め込むことができます。</p>

<h3>グループの設定</h3>

<p>phpSechduleItでのグループはユーザーを組織化し、リソース使用の可否を決定し、アプリケーション内での役割を定めます。</p>

<h3>役割</h3>

<p>役割はユーザーのグループに特定の操作を行う権限を与えます。</p>

<p>アプリケーション管理者の役割を与えられたグループのユーザーは、管理特権を行使することができます。</p>

<p>グループ管理者の役割を与えられたグループのユーザーは、グループのユーザーを管理し、ユーザー名義で操作することができます。</p>

<h3>予約の表示と管理</h3>

<p>
メニューの「予約」で予約の表示と管理を行うことができます。
デフォルトの設定では今日の前後7日間の予約が表示されます。
見つけたいものによって粒度を大きくも小さくもできます。
このツールで予約の様子をすばやく見ることができます。
また予約のリストをCSV形式で出力することができます。
</p>

<h3>予約の承認</h3>

<p>
予約管理ツールで承認保留中の予約を見ることができます。
保留中の予約はハイライト表示されています。
</p>

<h3>ユーザーの表示と管理</h3>

<p>
メニューの「ユーザー」から、ユーザーを登録したりユーザーを一覧することができます。
このツールでは次のようなことができます。
ユーザー個々にリソースの使用権限を変更する。
アカウントを使用不能にしたり削除する。
ユーザーパスワードをリセットする。
ユーザー情報の詳細を編集する。
新規ユーザーを追加するのもここです。
この機能には、ユーザー自身での登録を無効にしている場合、格段にお世話になります。
</p>

<h2>アプリケーションの設定</h2>

<p>phpScheduleItの機能の一部は設定ファイルを編集して設定するしかありません。</p>

<p class="setting"><span>$conf['settings']['server.timezone']</span>phpScheduleItが動作しているサーバーのタイムゾーンに合わせること。メニューの「サーバー設定」で現在の設定を確認することができる。可能な値は以下に示すサイトにある。http://php.net/manual/en/timezones.php
</p>

<p class="setting"><span>$conf['settings']['allow.self.registration']</span>ユーザー自身でアカウントを作成できるか否か</p>

<p class="setting"><span>$conf['settings']['admin.email']</span>アプリケーション管理者のメールアドレス</p>

<p class="setting"><span>$conf['settings']['default.page.size']</span>データのリストを表示する際のページあたりの表示数の初期値</p>

<p class="setting"><span>$conf['settings']['enable.email']</span>phpScheduleItがメールを送信するか否か</p>

<p class="setting"><span>$conf['settings']['default.language']</span>ユーザーのデフォルトの言語。phpScheduleItのlangディレクトリにある言語ならどれでも可</p>

<p class="setting"><span>$conf['settings']['script.url']</span>phpScheduleItインスタンスのルートへの完全な公開URL。これはbookings.php、calendar.phpのようなファイルを含んでいるWebという名のディレクトリがあるので、それにしておくこと</p>

<p class="setting"><span>$conf['settings']['password.pattern']</span>ユーザーアカウントを登録する際のパスワードに複雑さを強制する正規表現</p>

<p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>ユーザーが予約できないリソースをスケジュール中に表示するか否か</p>

<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>予約状況ページで各予約に表示する値。'name'、'title'、'none'。デフォルトは 'name'.</p>

<p class="setting"><span>$conf['settings']['image.upload.directory']</span>画像を保存する物理的なディレクトリのパス。このディレクトリに書き込みできる必要がある。この指定は完全ディレクトリ名(フルパス)またはphpScheduleItのルートディレクトリからの相対パスのいずれでもよい。</p>

<p class="setting"><span>$conf['settings']['image.upload.url']</span>そこにアップロードされた画像を表示することができるディレクトリのURL。完全なURLまたは$conf['settings']['script.url']からの相対URLのいずれでもよい。</p>

<p class="setting"><span>$conf['settings']['cache.templates']</span>テンプレートをキャッシュするか否か。tpl_cが書き込み可能なら、trueにすることが推奨される。</p>

<p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>ユーザーアカウントの登録時にキャプッチャを使うか否か</p>

<p class="setting"><span>$conf['settings']['inactivity.timeout']</span>ユーザーが自動的にログアウトするまでの時間を分で指定する。自動ログアウトを無効にしたいときは空文字列にすること。</p>

<p class="setting"><span>$conf['settings']['name.format']</span>first name、last nameの表示フォーマット。デフォルトは {literal}'{first} {last}'{/literal}。</p>

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

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>予約が作成されたとき、全てのリソース管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>予約が更新されたとき、全てのリソース管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>予約が削除されたとき、全てのリソース管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>予約が作成されたとき、全てのアプリケーション管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>予約が更新されたとき、全てのアプリケーション管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>予約が削除されたとき、全てのアプリケーション管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>予約が作成されたとき、全てのグループ管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>予約が更新されたとき、全てのグループ管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>予約が削除されたとき、全てのグループ管理者にメールを送るかどうか。デフォルトは false。</p>

<p class="setting"><span>$conf['settings']['css.extension.file']</span>インクルードしたい追加CSSの、完全または相対URL。デフォルトのスタイルを調整する程度から完全なテーマにまで上書きすることができる。phpScheduleItのスタイルを拡張しないなら空文字列にしておく。</p>

<p class="setting"><span>$conf['settings']['database']['type']</span>PEAR::MDB2 でサポートされている型の何れか</p>

<p class="setting"><span>$conf['settings']['database']['user']</span>データベースにアクセスするユーザー</p>

<p class="setting"><span>$conf['settings']['database']['password']</span>データベースユーザーのパスワード</p>

<p class="setting"><span>$conf['settings']['database']['hostspec']</span>データベースホストのURLまたは名前付きパイプ</p>

<p class="setting"><span>$conf['settings']['database']['name']</span>phpScheduleItが使うデータベース名</p>

<p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>PHPのメールライブラリ。mail、smtp、sendmail、qmail から選ぶ</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>smpt を使う場合の SMTPホスト</p>

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

<h2>プラグイン</h2>

<p>下記のコンポーネントがプラグイン可能になっています:</p>

<ul>
	<li>Authentication - 誰がログインできるか</li>
	<li>Authorization - ログインしたとき何ができるか</li>
	<li>Permission - ユーザーはどのリソースを使うことができるか</li>
	<li>Pre Reservation - 予約を作成する直前に何を実行するか</li>
	<li>Post Reservation - 予約を作成した直後に何を実行するか</li>
</ul>

<p>
プラグインを有効にするには、プラグインフォルダの名前を設定ファイルに書きます。
例えば、LDAP認証を有効にするには、次の設定を記述します。
	$conf['settings']['plugins']['Authentication'] = 'Ldap';
</p>

<p>
プラグインにはそれぞれの設定ファイルがあります。
LDAPの場合は、/plugins/Authentication/Ldap/Ldap.config.dist を/plugins/Authentication/Ldap/Ldap.configにリネームするかコピーし、すべての値を実行環境に合わせて編集します。
</p>

<h3>プラグインのインストール</h3>

<p>
新しいプラグインをインストールするにはそれのフォルダをAuthentication、Authorization、Permissionディレクトリのいずれかにコピーします。
そしてconfig.php の $conf['settings']['plugins']['Authentication']、$conf['settings']['plugins']['Authorization'] 、$conf['settings']['plugins']['Permission'] のいずれかの値をフォルダの名前に変更します。
</p>

{include file="support-and-credits.tpl"}
</div>

{include file='globalfooter.tpl'}