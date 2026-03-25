# Laravel-base-web

## Sobre projeto base feito em Laravel

A ideia desse sistema é criar uma base simples para a implementação de outros sistemas utilizando o laravel. Versão atual 12
Foi desenvolvido todo o controle para login de usuário (autenticação), criação de sistemas, modulos, funcionalidades, privilegios e perfil de usuário, além da implementação basica de log.
Para este projeto foi utilizado o laravel modules [laravel modules](https://github.com/nWidart/laravel-modules) onde temos a pasta modules com dois modulos criados o Base e Seguranca.
A ideia é tratar tudo que for de utilização de todos ou seja a base de funcionamento do sistema como por exemplo controller base, model base, entre outros... no modulo Base.
O modulo Seguranca trata as questões de segurança do sistemas, que são cadastro de usuario, funcionalidade entre outros.


## Instalação do projeto

- Após realizar o clone do projeto necessário configurar o arquivo .env com as conexões do banco.
- Instalar e atualizar o projeto via composer, (compose update) para que seja instalado as dependencias
- Instalar e atualizar o projeto com node (npm install) para que seja instalado as dependencias
- Executar as migration - php artisan module:migrate Seguranca
- Executar os seeds - php artisan module:seed Seguranca
- executar npm run build - para poder gerar os arquivos saas
- Por padrão já vem 1 usuário admin@email.com com a senha 123456


## Padrões para desenvolvimento

- Para criação de models, controller, utilizar os comandos de criação utilizando o [laravel modules](https://github.com/nWidart/laravel-modules)
- Toda controller deverá extender da controler base Modules, pois nele já foi implementado uma serie de funções e padrões para criação das telas => 'Modules\Base\Http\Controllers\BaseController'
- Toda entidade(model) deverá extender do model base, pois nele já foi implementado uma serie de funções e padrões para criação das telas => 'Modules\Base\Models\BaseModel'
- Para a listagem dos dados no grid o projeto está utilizando o [bootstrap-table](https://examples.bootstrap-table.com/)
- Toda Nome de controller e model criado deverão ser iguais e no plural 


