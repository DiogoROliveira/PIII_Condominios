# Plataforma de Gestão de Reclamações de Condomínio

## Objetivo
Este projeto tem como objetivo criar uma plataforma online para gestão de reclamações de um condomínio. Através desta plataforma, os moradores podem submeter, consultar e acompanhar o estado das suas reclamações, enquanto a administração pode gerir as ocorrências de forma centralizada e eficiente.

## Contexto Académico
Este projeto foi desenvolvido no âmbito da Unidade Curricular de **Projeto III** em parceria com o **Instituto Politécnico de Viana do Castelo (IPVC)** e a empresa **FTKode**.

# Coordenadores
- Prof. Jorge Ribeiro
- Eng. Miguel Guerra

## Tecnologias Utilizadas
- **PHP** (Framework Laravel)
- **MySQL** (Base de dados relacional)

## Como dar Deploy

1. **Criar a Base de Dados**: Antes de dar deploy à aplicação, certifique-se de que a base de dados está criada no seu servidor MySQL.
   
2. **Configuração do Ficheiro `.env`**: No diretório raiz do projeto, existe um ficheiro `.env` onde deverá configurar as variáveis de ambiente. Abaixo estão as principais variáveis relacionadas com o banco de dados que devem ser ajustadas:
   
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nome_da_base_de_dados
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

## 3. Migrar as Tabelas

Após configurar corretamente o arquivo `.env`, você precisa criar as tabelas no banco de dados. Para isso, execute o seguinte comando:

```bash
php artisan migrate
```

## Como Correr a Aplicação Localmente

Para rodar o projeto em um ambiente local, execute o seguinte comando:

```bash
php artisan serve
```

Isso iniciará o servidor embutido do Laravel. A aplicação ficará disponível em http://localhost:8000.

## Requisitos
- **PHP** >= 8.0
- **Composer** para gestão de dependências do PHP
- **MySQL** ou outra base de dados compatível com Laravel

## Instruções Adicionais
- **Composer**: Certifique-se de ter as dependências instaladas. Caso contrário, execute:
  ```bash
  composer install
  ```

## Contribuidores
  
Projeto desenvolvido por David Reis e Diogo Oliveira, em parceria com **IPVC** e **FTKode**.

<img src="https://github.com/user-attachments/assets/bc2cc843-52e0-4904-a5bb-85d31b412aee" width="300" margin="50" />
<img src="https://github.com/user-attachments/assets/0d636f69-69ad-4d3e-b8c8-2d9f778f5a41" width="300" margin="50" />


