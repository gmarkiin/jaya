
# Jaya - Test

## BACKEND
Para preparar o ambiente siga os seguintes comandos:

    cp .env.example .env
    docker-compose up -d
    docker-compose exec jaya_nginx bash -c "su -c \"composer install\" application"
    docker-compose exec jaya_nginx php artisan migrate

O projeto do backend possui um arquivo de make, que basicamente executa alguns comandos no terminal, caso tenha interesse 
por eles vou deixar nos aliases as informacoes do que os comandos fazem.

Para verificar o coverage de testes do backend execute o seguinte comando:

    docker compose exec --user application jaya_nginx php artisan test --coverage

Para  executar os testes basta executar o seguinte comando:

    docker compose exec --user application jaya_nginx php artisan test

## FRONTEND
#
Após isso acesse a pasta frontend e execute o seguinte comando para realizar a build do front

    yarn install && yarn quasar dev --watch
#
Para executar os testes unitários também preparei um script a fim de agilizar a execução do comando
