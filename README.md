# docker-serverhealth
Get important infos, stats and health from your self-operating servers via Nagios, Prometheus, ...

### Features
- [x] Simple nagios or prometheus metrics in a container

### Build status:
[![Build Status](https://img.shields.io/github/workflow/status/andreaskasper/docker-serverhealth/Docker%20Image%20CI)](https://hub.docker.com/r/andreaskasper/serverhealth)
![Build Status](https://img.shields.io/docker/image-size/andreaskasper/serverhealth/latest)

### Bugs & Issues:
![Github Issues](https://img.shields.io/github/issues/andreaskasper/docker-serverhealth.svg)

### Stats:
![Code Languages](https://img.shields.io/github/languages/top/andreaskasper/docker-serverhealth.svg)
![Docker Pulls](https://img.shields.io/docker/pulls/andreaskasper/serverhealth.svg)

### Running the container :

#### Simple Run

```sh
$ docker run -d -h example.com -p 8080:80 -e API_KEY=changethis123 andreaskasper/serverhealth:latest
```

### Environment Parameters
| Parameter     | Description                                             | Example       |
| ------------- |:-------------------------------------------------------:|:-------------:|
| API_KEY       | The password/token you wanna use to access your metrics | secret123     |



### Folders:
| Folder        | Description               |
| ------------- |:-------------------------:|
| /var/www/html | The website/script folder |



### Steps
- [x] Build a base test image to test this build process (Travis/Docker)
- [ ] Build tests
- [ ] Gnomes
- [ ] Profit

### Links
[🐋 Docker Hub](https://hub.docker.com/r/andreaskasper/serverhealth)

### support the projects :hammer_and_wrench:
[![donate via Patreon](https://img.shields.io/badge/Donate-Patreon-green.svg)](https://www.patreon.com/AndreasKasper)
[![donate via PayPal](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/AndreasKasper)
