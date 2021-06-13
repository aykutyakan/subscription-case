## Kurulum
```sh
$ git clone https://github.com/aykutyakan/subscription-case .
$ compoer install
$ mv .env.example .env
$ php artisan key:generate
```
## Veritabanı kurlumu
Veritabanı bilgilerini .env dosyasına yazalım ve sonra aşağıdaki komutları çalıştıralım

```sh
$ php artisan migrate
$ php artisan db:seed
```

## Sistem API Kullanımı
Sistemde kayıtlı olan endpoint 
```sh
 api\device-register PUT
 api\check-subscription GET
 api\app-subscription GET
```

### Cihaz Kaydetme
Sisteme kullanımı için yapılacak ilk iş cihazın app bilgisi ile kaydedilmesi gerekiyor.
Kaydetme işlemi `api\device-register` endpointe `PUT` isteği atmasıdır.Bu istek içinde bazı bilgilerin parametrelerin olması gerekiyor.
Gönderilecek parametre şu şekilde olmalı.


**uid**: Cihazın ID değeri olacak\
**app_id** : Uygulamanın ID değeri olacak\
**language** Uygulamanın kullandığı dil olacak\
**operating_system** Uygulamanın çalıştığı işletim sistemi olacak. Parametre sadece *`ios`* veya *`android`* değerlerini kabul edecektir\
**os_username** Ugulamanın google ve Ios için doğrulama yapacağı basic authenticated bilgisi olacak. Kullanıcı adı olarak kullanılacak\
**os_password** Ugulamanın google ve Ios için doğrulama yapacağı basic authenticated bilgisi olacak.Şifre olarak kullanılacak\

Sisteme bu parametreler ile istek atıldığında validasyon işlemi çalışacak ve bu veriler doğrulanırsa sisteme kayıt edilecek. Kayıt işlemi sonrasında geriye bir **client_token** değeri döndürülecek. Bundan sonraki api istekleri bu token ile erişim sağlanacaktır. Tekrar istek atması halinde var olan `client_token` nesnesi güncellenecektir.

### Abonelik başlatma 
Sistemde kayıtlı olan cihazların abonelik hizmetini başlatmasını sağlayan servistir. İstek yapmak için `api\app-subscription`  endpoint adresi kullanılacaktır. Bu endpoint atılacak istekleri için gerekli olan parametreler şunlardır.
**client_token :** Kayıtlı olan cihazlarda bulunan token değeri\
**reciept :** Abonelik işlemi için yaptığı ödemenin dekont numarası.\
Atılan istek sonucunda token değeri ve reciept değeri kontrol edilecek 
Kontrol edildikten sonra işlemler başarılı ise geriye expire_date dönüş süresini ve is_ative durumunu belirten değerler dönecektir.

### Abonelik kontrolü
Sistemde kayıtlı olan cihaz sahip olduğu aboneliğin durumunu görebilecektir. Kontrol edebilmek için sisteme `api\check-subscription` endpoint adresini kullanmalıdır. Bu adrese yapacağı istekte ise gerekli olan parametre `client_token` parametresi gereklidir.
**client_token :** Kayıtlı olan cihazlara verilen token değeri
Yapılan istek sonucunda kontrol edilen token değerine uygul olan aboneliğin durumu `subscription` değeri ile boolean şeklinde döndürülecektir.
## Sistem Worker Kullanımı
Worker arka planda çalışacak olan abonelik hizmetini kontrol eden servislerimizdir. Worker çalıştığı zaman sistemde kayıtlı olan tüm süresi geçmiş abonelikler belirli aralıklarla ve belirli adetler olmak üzere kontrole edilecektir. Süresi geçmiş  ve durumu aktif olan abonelik tekrar doğrulama işlemi yapılacak. Bu doğrulama işlemi sonucunda başarılı ise sistemdeki abonelik tarihi güncellenecek güncellenecek. Worker çalışması için shell ekrarnından aşağıdaki komut çalıştırılmalıdır.Bu komut ile sistem her 5 dk içerisinde (varsayılan 100 adet) kayıtları kontrol edecektir.
```sh
php artisan schedule:work
```
Ayrıca cronjob olarak aşağıdaki komut yardımı ile çalıştırılabilir.
```sh
php artisan subscription:expired
```


## Calback işlemi

Sistemde abonelikler üzerinde bir işlem yapıldığı zaman işlemin durumu(started, renewed, canceled) işlemleri için tetiklenecektir. DB üzerinde kayıtlı endpoint adresine `deviceId, appId, type`  parametreleri ile  istek atılacaktır. 

## Raporlama işlemi

Sistemde yapılan günlük işlemlerin özetini alabileceği sistemdir. Raporlama almak için aşağıdaki endpointe istek atılmalıdır. 
```sh
GET api/subscription-report
```
Yapılan istek sonuncunda `started renewed canceled` değerlerine ait toplam sayılar dönecektir.
