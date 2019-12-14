# dapr-php

## これはなに
microsoftが公開したdaprというruntimeを使ったPHPのサンプルプロジェクトです。

daprについては公式を見てもらうのが良いと思いますが、
ざっくり説明としては、イベント駆動アーキテクチャを実現させるためのランタイムです。

daprdとの通信はHTTPやgrpcが使われるので言語に依存せず実装できます。

PHPをRoadrunnerを使うことでdaprと接続しています。

### setup
```bash
docker-compose -f docker-compose-setup.yml up
```

### run project
```bash
//　プロジェクトが立ち上がります 
docker-compose up -d

// プロジェクト全体のlogが見れます
docker-compose logs -f

// 別ターミナルを開いて、postをするとpub/subで処理が走るのをログから確認できます。
// ユースケースとして、ユーザー作成完了時に管理者と登録ユーザーに通知を送る想定です。
curl -X POST "localhost:8080/createUser"
```

### 処理の流れ
curl -> api-facade -> dapr-endpoint <-->　(admin-notification-service, user-notification-service) 
