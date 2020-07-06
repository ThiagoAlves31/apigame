### APIGAME
----
Pré-requisitos:
- [Git](https://git-scm.com/ "Git")
- [Composer](https://getcomposer.org/ "Composer")
- [Docker](https://docs.docker.com/get-started/ "Docker")
- [Docker Compose](https://docs.docker.com/compose/install/ "Docker Compose")

#### Para iniciar o projeto siga os passos abaixo:
```
git clone https://github.com/ThiagoAlves31/apigame.git
```
```
cd apigame
```
```
cp .env-example .env
```
```
#### Iniciar container:

```
docker-compose up -d --build 
```
#### Após iniciar o container vamos acessá-lo para algumas configurações:
```
docker exec -it apigame-docker-php-fpm bash
```
#### A partir de agora já estamos dentro do container.
Vamos adicionar permissão nos Logs, por ser ambiente de teste vai ser 777 mesmo.
```
chmod -R 777 storage/*
```
Criar tabelas e adicionar dados fictícios.
```
php artisan key:generate
php artisan migrate
php artisan db:seed

Pronto, já estamos com o ambiente funcionando
Basta apenas acessar http://localhost:8080/api/fighters

### Utilizando API
```
GET - http://localhost:8080/api/fighters    - Mostra todos os lutadores disponiveis 
GET - http://localhost:8080/api/weapons     - Mostra as armas disponiveis
GET - http://localhost:8080/api/rounds      - Todas as rodadas de todas as batalhas
GET - http://localhost:8080/api/rounds/1    - Todas as rodadas da batalha com id 1
GET - http://localhost:8080/api/battles     - Todas as batalha

#Iniciando uma batalha
Utilizar alguma ferramenta de RESTful, Postman por exemplo

POST http://localhost:8080/api/battles - Passando como parametros no bay da requisição (Key-Value) orc_id e human_id
Exemplo
{
    "orc_id":1
    "human_id":1
}

Após a requisição irá retornar a batalha que foi criada, com abaixo;
{
    "id": 6,
    "human_life": 12,
    "orc_life": 20,
    "human_id": 2,
    "orc_id": 1,
    "win": null,
    "win_id": null,
    "rounds": null,
}

#Iniciando uma batalha 
POST http://localhost:8080/api/rounds/6  - No caso o 6 é o id da batalha criada anteriormente. 

Cada POST realizado será uma rodada da luta sempre retornando algo como:
{
    "0": "Orc levou dano de 5",
    "1": "Human nao levou dano. Se defendeu bem -> ataque=18  defesa=19",
    "2": {
        "id": 1,
        "human_life": 6,
        "orc_life": 15,
        "human_id": 2,
        "orc_id": 1,
        "win": null,
        "win_id": null,
        "rounds": 2,
        "created_at": "2020-07-06T02:49:05.000000Z",
        "updated_at": "2020-07-06T03:04:34.000000Z"
    },
    "Round": 2
}

A batalha se encerra quando algum oponente tiver com 0 ou menos de vida tendo como resultado do POST algo como:

{
    "Status": "Battle end",
    "Battle": {
        "id": 1,
        "human_life": 6,
        "orc_life": -1,
        "human_id": 2,
        "orc_id": 1,
        "win": "Human",
        "win_id": 2,
        "rounds": 5,
        "created_at": "2020-07-06T02:49:05.000000Z",
        "updated_at": "2020-07-06T03:05:43.000000Z"
    }
}

Ao verificar novamente os dados dos lutadores em GET - http://localhost:8080/api/fighters  
pode se verificar o numero de batalhas, o numero de derrotas e o numero de vitórias.

Isso é o básico para se criar uma batalha entre 2 oponentes.




