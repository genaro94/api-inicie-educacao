## Inicie Educação Challenge

### 🚀Sobre o Projeto

Esta é uma API REST criada com o Laravel no qual disponibiliza a criação de posts, comentários de usuário em um blog.

### 💻Tecnologias

Além das ferramentas abaixo, esta aplicação foi desenvolvida com as melhores práticas de desenvolvimento do mercado!

* Laravel
* SOLID
* TDD
* Docker

### 📚Guia de Instalação e Execução

#### Pré-requisitos

* [Git](https://git-scm.com/https:/)
* [Composer](https://getcomposer.org/https:/)
* [Docker Desktop](https://docs.docker.com/desktop/install/windows-install/https:/)
* [Laravel](https://laravel.com/docs/9.x/installationhttps:/)

#### Como Executar

* Clone o projeto `git clone https://github.com/genaro94/api-inicie-educacao.git`
* Digite o `composer install` no terminal do projeto. Ele vai instalar todos os pacotes php necessários
* Digite o `php artisan key:generate`. Esse vai gerar uma chave para sua aplicação. Sem isso o Laravel não vai funcionar
* Digite o `docker-compose up -d`. Ele vai subir todos as imagens necessárias e rodar o projeto.
* Verifique os nomes das imagens com `docker ps`
* Acesse a imagem da aplicação com `docker exec -it api-inicie-educacao_laravel-app_1 bash`. Onde o api-inicie-educacao_laravel-app_1 é o nome da imagem
* Crie o link simbólico com `ln -s public html`
* Gere as migrates com `php artisan migrate:refresh --seed`. Ele vai criar todas as tabelas necessárias no database

Pronto, após seguir o passo a passo só precisará acessar o link [localhost:8080](https://[localhost:8080]) no seu navegador e começar a usar a aplicação.

Caso deseje executar os testes basta executar `vendor/bin/phpunit` em seu terminal.

### CheckList da API

* [X] Criar um novo usuário dentro do sistema;
* [X] Listar todos os usuários da API e encontrar o usuário criado através do ID do mesmo;
* [X] Criar um novo post para o usuário criado;
* [X] Criar um novo comentário dentro do post criado;
* [X] Criar um novo comentário dentro do primeiro post da lista pública de posts;
* [X] Apagar o comentário criado no requisito acima;
* [X] Listagem do posts de um usuário;

### Rotas Disponíveis

<table>
	<thead>
		<th>Description</th>
		<th>Method</th>
		<th>Url</th>
		<th>QueryString</th>
		<th>Body</th>
		<th>Response</th>
	</thead>
	<tbody>
    	<tr>
			<td>Criar Usuário</td>
			<td>POST</td>
			<td>api/users</td>
			<td>none</td>
			<td>
                <pre>
{
    "name": "Maria Mehrotra Silva",
    "email": "maria@email.com.br",
    "gender": "female",
    "status": "active"
}
                </pre>
            </td>
			<td>
				<pre>
{
    "code": 201,
    "meta": null,
    "data": {
        "id": 5862,
        "name": "Maria Mehrotra Silva",
        "email": "maria@email.com.br",
        "gender": "female",
        "status": "active"
    }
}
				</pre>
			</td>
		</tr>
    	<tr>
			<td>Listar Todos Usuários</td>
			<td>GET</td>
			<td>api/users/{user?}</td>
			<td>none</td>
			<td>
               none
            </td>
			<td>
				<pre>
{
    "code": 200,
    "meta": {
        "pagination": {
            "total": 2241,
            "pages": 225,
            "page": 1,
            "limit": 10
        }
    },
    "data": [
        {
            "id": 2303,
            "name": "Msgr. Chitraksh Rana",
            "email": "chitraksh_msgr_rana@fay.name",
            "gender": "male",
            "status": "active"
        },
        {
            "id": 2302,
            "name": "Bhoopat Bharadwaj I",
            "email": "bharadwaj_bhoopat_i@ward.info",
            "gender": "male",
            "status": "active"
        },
    ]
}
				</pre>
			</td>
		</tr>
        <tr>
			<td>Criar Post para o Usuário</td>
			<td>POST</td>
			<td>api/users/{user}/posts</td>
			<td>none</td>
			<td>
                <pre>
{
    "title": "Title de Exemplo",
    "body": "Body de Exemplo"
}
                </pre>
            </td>
			<td>
				<pre>
{
    "code": 201,
    "meta": null,
    "data": {
        "id": 1487,
        "user_id": 370,
        "title": "Title de Exemplo",
        "body": "Body de Exemplo"
    }
}
				</pre>
			</td>
		</tr>
        <tr>
			<td>Criar Comentário dentro do Post Criado</td>
			<td>POST</td>
			<td>api/posts/{post}/comments</td>
			<td>none</td>
			<td>
                <pre>
{
    "name": "Maria da Conceição",
    "email": "maria@email.com",
    "body": "body exemple"
}
                </pre>
            </td>
			<td>
				<pre>
{
    "code": 201,
    "meta": null,
    "data": {
        "id": 1348,
        "post_id": 1487,
        "name": "Maria da Conceição",
        "email": "maria@email.com",
        "body": "body exemple"
    }
}
				</pre>
			</td>
		</tr>
        <tr>
			<td>Criar Comentário dentro do Post público</td>
			<td>POST</td>
			<td>api/comments/store/list/posts</td>
			<td>none</td>
			<td>
                <pre>
{
    "post_id": 1441,
    "name": "Carson Rempel",
    "email": "carson@meial.com",
    "body":  "asdasda"
}
                </pre>
            </td>
			<td>
				<pre>
{
    "code": 201,
    "meta": null,
    "data": {
        "id": 1350,
        "post_id": 1441,
        "name": "Carson Rempel",
        "email": "carson@meial.com",
        "body": "asdasda"
    }
}
				</pre>
			</td>
		</tr>
        <tr>
			<td>Apagar Comentário</td>
			<td>DELETE</td>
			<td>api/comments/{comment}</td>
			<td>none</td>
			<td>
                none
            </td>
			<td>
                none
			</td>
		</tr>
        <tr>
			<td>Listagem dos Posts do Usuário</td>
			<td>GET</td>
			<td>api/users/{user}/posts</td>
			<td>none</td>
			<td>
                none
            </td>
			<td>
                <pre>
{
    "code": 200,
    "meta": {
        "pagination": {
            "total": 1,
            "pages": 1,
            "page": 1,
            "limit": 10
        }
    },
    "data": [
        {
            "id": 1168,
            "user_id": 2303,
            "title": "title example",
            "body": "body example"
        }
    ]
}
                </pre>
			</td>
		</tr>
	</tbody>
</table>

By Genaro Figueiredo 👋
