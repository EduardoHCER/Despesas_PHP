# 🚀 Projeto: Controle de Despesas Pessoal

Bem-vindo ao projeto de Controle de Despesas Pessoal! Este é um sistema web simples, porém funcional, desenvolvido para ajudar usuários a gerenciar suas finanças pessoais de forma eficiente e segura.

O projeto foi construído como uma aplicação prática para demonstrar habilidades em desenvolvimento back-end com PHP, seguindo boas práticas de segurança, organização de código e interação com banco de dados.

## ✨ Funcionalidades Principais

* **Autenticação de Usuário:** Sistema completo de cadastro, login e logout com senhas criptografadas (hash).
* **Gerenciamento de Sessão:** Proteção de rotas para garantir que apenas usuários autenticados acessem as páginas internas.
* **CRUD de Despesas:** Funcionalidade completa para Criar, Ler, Atualizar e Deletar (CRUD) itens de despesa.
* **Segurança:**
    * Uso de `Prepared Statements` (via PDO) para prevenir injeção de SQL.
    * Validação de dados no back-end.
    * Verificação de propriedade para garantir que um usuário só possa ver, editar e excluir suas próprias despesas.
* **Interface Amigável:** Layout responsivo e agradável construído com Bootstrap 5.

## 🛠️ Tecnologias Utilizadas

* **Back-end:** PHP 8
* **Banco de Dados:** MySQL
* **Conexão DB:** PDO (PHP Data Objects)
* **Front-end:** HTML5, CSS3, Bootstrap 5
* **Servidor Local:** XAMPP (ou similar)

## 📋 Pré-requisitos

Para executar este projeto localmente, você precisará de um ambiente de servidor web com suporte a PHP e MySQL. A forma mais fácil é utilizando um pacote como o [XAMPP](https://www.apachefriends.org/pt_br/index.html) ou WAMP.

## ⚙️ Como Instalar e Executar

Siga os passos abaixo para configurar e rodar o projeto em sua máquina.

**1. Clone ou Baixe o Projeto**
   - Baixe os arquivos do projeto e descompacte-os.
   - Mova a pasta do projeto (ex: `controle-despesas`) para o diretório `htdocs` da sua instalação do XAMPP (normalmente `C:/xampp/htdocs/`).

**2. Crie e Importe o Banco de Dados**
   - Inicie os módulos Apache e MySQL no painel de controle do XAMPP.
   - Abra seu navegador e acesse o phpMyAdmin em `http://localhost/phpmyadmin`.
   - Crie um novo banco de dados com o nome `controle_despesas`.
   - Selecione o banco `controle_despesas` recém-criado e clique na aba "Importar".
   - Clique em "Escolher arquivo" e selecione o arquivo `controle_despesas.sql` que está na raiz do projeto.
   - Clique em "Executar" no final da página. As tabelas `usuarios` e `itens` serão criadas.

**3. Configure a Conexão (se necessário)**
   - O arquivo de conexão (`config/conexao.php`) está configurado com os padrões do XAMPP (usuário: `root`, senha: em branco).
   - Se a sua configuração de MySQL for diferente, ajuste as credenciais neste arquivo.

**4. Acesse o Sistema**
   - Com o Apache e o MySQL rodando, acesse o projeto pelo navegador:
     ```
     http://localhost/controle-despesas/
     ```
   - Você será redirecionado para a página de login.

## 🔑 Credenciais de Teste

Você pode se cadastrar como um novo usuário ou usar as credenciais abaixo para um teste rápido:

* **Login:** `teste`
* **Senha:** `123`

## 📁 Estrutura de Arquivos

O projeto está organizado da seguinte forma para facilitar a manutenção e escalabilidade: