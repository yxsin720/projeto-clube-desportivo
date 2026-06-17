# Clube Desportivo

## Descrição

Aplicação web para a gestão integral de um clube desportivo de ténis e pádel.
Permite que atletas pesquisem e reservem campos, giram e consultem as suas reservas
mediante autenticação, e que a equipa do clube (gestor e rececionista) administre
campos, atletas, reservas, registe pagamentos simulados, efetue a confirmação de
comparência (check-in) e extraia relatórios estatísticos.

## Funcionalidades

- Registo e autenticação de utilizadores com hashing de password
- Pesquisa e reserva de campos por tipo (Pádel Coberto, Pádel Descoberto, Ténis Terra Batida, Ténis Rápido)
- Suplementos de iluminação noturna e aluguer de material (raquetes/bolas)
- Gestão de reservas pelo atleta (listar, editar e cancelar até 24h antes do jogo)
- Cálculo automático do valor total da reserva com suplementos incluídos
- Registo de pagamentos simulados (parcial ou total)
- Backoffice com dois perfis: gestor e rececionista
- Confirmação de check-in pelo backoffice
- Gestão de atletas (ativar/inativar)
- Relatórios de ocupação diária, estado das reservas, receita por tipo de campo e histórico de atletas
- Validação de sobreposição de horários no mesmo campo

## Stack Tecnológica

- **HTML5 / CSS** — estrutura e estilo das páginas
- **JavaScript** — cálculo dinâmico de valores
- **PHP** — backend e ligação à base de dados com prepared statements
- **MySQL** — base de dados relacional
- **Apache (MAMP)** — servidor local

## Instalação

1. Clonar o repositório para a pasta `htdocs` do MAMP:
git clone https://github.com/yxsin720/projeto-clube-desportivo.git
2. Iniciar o MAMP (Apache + MySQL)
3. Abrir o phpMyAdmin em `http://localhost/phpMyAdmin`
4. Criar uma base de dados com o nome `clube_desportivo`
5. Importar o ficheiro `config/database.sql`
6. Confirmar as credenciais em `config/database.php`
7. Aceder no browser a `http://localhost/clube-desportivo`

## Credenciais de Teste

### Administrador (Gestor)
- Registar uma conta em `/register.php`
- No phpMyAdmin alterar o campo `role` para `gestor` na tabela `users`
- O gestor é redirecionado automaticamente para o painel de administração

### Atleta
- Registar uma conta diretamente em `/register.php`

## Autor

Yassir Shameel Mac-Arthur Latif
Universidade Europeia — Engenharia Informática
Projeto Desenvolvimento Web — 2025/2026