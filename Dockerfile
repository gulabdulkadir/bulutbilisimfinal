FROM php:8.2-apache 
#bana sıfırdan işletim sistemi kurup, üstüne php kurmakla uğraşma onun yerine daha önce hazırlanmış olan paket docker hubtan al ve başlangıç noktam yap.
RUN docker-php-ext-install mysqli pdo pdo_mysql 
#RUN imaj oluştururken makinenin içinde terminal çalıştırır, veritabanı ile konuşmak için dönüştürücü vs lazım
# mysqli, pdo gibi eklentilere ihtiyaç var. 
COPY ./app /var/www/html/ 
# bilgisayardaki ya da githubtaki dosyaları alır ve sanal makineni içine gönderir. /var/www/html/ yayın yapacağım
# sitenin dosyaları burda kalsın dediğim klasikleşmiş linux klasörü.
EXPOSE 80 
# konteynerın dış dünyayla hangi port üzerinden konuşacağını belirler.