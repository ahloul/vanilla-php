## Run application
### Run application by docker
```bash
# Run application
$ docker-compose up --build --remove-orphans 
# or
$ docker-compose up 


 
```
### Run application by php
```bash
# go to app directory
$ composer dump-autoload   

$  php -S localhost:9000    

 
```
Go to http://localhost:9000/
####Can change port in docker-compose file  "9000" to any valid other port and need to change it in vue app too


### Query Params
* country_code : country code to filter by country (212|237|251|258|256)
* valid : true of false
* page page number


##### Example of returned values
```bash
 
{
  "data": [
  {
  "country": "Morocco",
  "state": 1,
  "country_code": "+212",
  "phone_number": "698054317"
  },
  {
  "country": "Morocco",
  "state": 1,
  "country_code": "+212",
  "phone_number": "691933626"
  },
  {
  "country": "Morocco",
  "state": 1,
  "country_code": "+212",
  "phone_number": "633963130"
  },
  {
  "country": "Morocco",
  "state": 1,
  "country_code": "+212",
  "phone_number": "654642448"
  }
  ],
  "pagination": {
  "page": 1,
  "total_items": 4,
  "items_per_page": 5,
  "total_pages": 2
  }
  }
  ```

http://localhost:9000/?country_code=212&valid=true&page=1
#### Notes
* make enusre renamed .env.exmaple
* to install docker Mac or windows [link](https://www.docker.com/products/docker-desktop) for Ubuntu [link](https://docs.docker.com/engine/install/ubuntu/)

