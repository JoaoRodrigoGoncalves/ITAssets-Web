IT ASSETS
---------

**Processo de configuração do sistema**

Instalar packages do composer

    composer install

Init do projecto (definir dev ou prod)

    php init

Configurar base de dados no `common\config\main-local.php`

> 'dsn' => 'mysql:host=localhost;dbname=**\<Nome da base de dados>**',

Aplicar migrações principais

    php yii migrate

Aplicar migrações especificas do RBAC

    php yii migrate --migrationPath=@yii/rbac/migrations

Aplicar permissões/roles do RBAC

    php yii rbac/write