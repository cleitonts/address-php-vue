## To run the project you can use docker and npm

docker will build most of the things except DB. 
You need to create a DB and run the script.
after container running you can bash into it and install composer dependencies.

npm is not installed inside a container, 
so you'll need to have it in your machine and run "npm i" then "npm run dev" 
inside frontend folder.

the base url for backend should be localhost:8080 and frontend localhost:5173, 
if you run the app without docker or in another port be sure to update .env files too.