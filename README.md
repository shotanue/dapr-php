# dapr-php

## これはなに
microsoftが公開したdaprというruntimeを使ったPHPのサンプルプロジェクトです。

daprについては公式を見てもらうのが良いと思いますが、
ざっくり説明としては、イベント駆動アーキテクチャを実現させるためのランタイムです。

daprdとの通信はHTTPやgrpcが使われるので言語に依存せず実装できます。

PHPをRoadrunnerを使うことでdaprと接続しています。

### run project
```bash
// setup(volumeしてあるディレクトリでcomposer installが走ります)
docker-compose -f docker-compose-setup.yml up

//　プロジェクトが立ち上がります 
docker-compose up -d

// プロジェクト全体のlogが見れます
docker-compose logs -f

// 別ターミナルを開いて、postをするとpub/subで処理が走るのをログから確認できます。
// フォロワーが増えた際にemailとpush通知を送るケースを想定しています。
// 実装自体は空で、サンプルのpub/subがちゃんと動いているかアクセスログで確認するような感じです。
curl -X POST "localhost:8080/follower"
```

### 処理の流れ
curl -> api-facade -> dapr-endpoint <-->　(admin-notification-service, user-notification-service) 
