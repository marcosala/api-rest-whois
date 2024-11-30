## Whois API
Per ottenere il whois passare in **GET** il parametro **domain** all'endpoint **/whois.json** 

### deploy del servizio
```
docker pull marcosala/api-rest-whois:latest
docker run -d -p 8080:80 marcosala/api-rest-whois:latest
```

### esecuzione dei test automatici
```
docker run -it marcosala/api-rest-whois:latest bash
vendor/bin/phpunit --testdox
```

### esempio di chiamata client

```
const requestOptions = {
  method: "GET",
  redirect: "follow"
};

fetch("http://localhost:8080/whois.json?domain=google.com", requestOptions)
  .then((response) => response.text())
  .then((result) => console.log(result))
  .catch((error) => console.error(error))
```

