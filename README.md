# API CARROS

Para usar a API são necessários os seguintes requisitos:
  * servidor web rodando PHP versão 5.6 ou superior
  * banco de dados MySQL ou mariaDB(10.1.13)
  * algum tipo de aplicativo para consumir o serviço(navegador ou postman/similares)
 
 
 
Para rodar a API:
  1. Crie o banco de dados utilizando o arquivo carros.sql localizado dentro da pasta db
  2. copie todo o repositório para a pasta pública do seu servidor web(public_html ou htdocs)
  3. instale via composer utilizando o comando composer install dentro da pasta raiz do projeto
  4. mude as configurações do arquivo src/settings.php de acordo com o seu BD e chave de preferencia(JWT)
  5. teste a api de acordo com as informações contidas em - https://www.getpostman.com/collections/7beb936602fe49d5a0bd
   *lembrar de colocar o endereço do seu servidor já que as informações na coleção acima estão apontando para o meu app em produção
