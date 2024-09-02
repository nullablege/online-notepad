Online Note-Taking Application
This README file provides information on setting up, using, and managing your Online Note-Taking Application. This application allows users to securely manage their notes.


Online Note-Taking Application
This README file provides information on setting up, using, and managing your Online Note-Taking Application. This application allows users to securely manage their notes.

Installation
Database Import

Import the egenots.sql file into your MySQL database using phpMyAdmin or MySQL command line.

Create SQL Event

To automatically clean up IP addresses, run the following SQL commands:
CREATE EVENT clean_ip
ON SCHEDULE EVERY 1 HOUR
DO
  DELETE FROM ip
  WHERE timestamp < NOW() - INTERVAL 1 HOUR;

Enable Event Scheduler

To ensure events can run, enable the global event scheduler:

SET GLOBAL event_scheduler = ON;

Overview
This application is an online note-taking system that allows users to securely manage their notes. Users can access and edit their notes from anywhere at any time. Passwords are securely hashed, and user information can be managed through the admin panel.

Features
User Features
Password Security: User passwords are not stored in plain text. They are hashed using a special algorithm.

Note Management: Users can create, save, edit, and delete notes. Deleted notes are permanently removed.

Personal Information: Users can add or update email, date of birth, address, and phone number from the settings section. They can also update their existing passwords.

Admin Features
Permission Management: To grant admin rights to a user, change the corresponding column in the auth table from 0 to 1.

Updates Page: Publish or remove system updates via the admin panel.

Account Management: Activate or deactivate user accounts.

IP Address Management: View IP addresses and locations that have accessed the site in the past hour. You can ban these IP addresses directly from the system or lift existing bans.

Support Requests: View and respond to support requests, which are color-coded and sorted by priority.

Security System: Enable or disable the security system with a single button. This system automatically bans IP addresses if a change is detected after a user logs in.

Security and Privacy
IP Address Security: IP addresses are used solely for security purposes and are not recorded. No IP address is stored on the site for more than one hour, except banned IPs.

Data Retention: Passwords, IP addresses, and other user information are managed and stored with strict security measures.

SQL Event Configuration
The system uses SQL events to automatically clean up IP addresses. The following code deletes IP addresses older than one hour from the IP table:

CREATE EVENT clean_ip
ON SCHEDULE EVERY 1 HOUR
DO
  DELETE FROM ip
  WHERE timestamp < NOW() - INTERVAL 1 HOUR;

Enable the event scheduler to allow the event to run:

SET GLOBAL event_scheduler = ON;

Admin Panel Notes
Performance: The speed of accessing the admin panel may vary depending on your internet connection. Pages are dynamically generated using data from APIs.

Local Testing: If running the site on localhost, your IP may be detected as ::1, which can cause some API issues. To avoid this, remove the ::1 IP addresses from the banned and ip tables and manually add valid IP addresses.



-----------------------------------------------------------


Online Not Alma Uygulaması
Bu README dosyası, Online Not Alma Uygulamanızı kurma, kullanma ve yönetme hakkında bilgi sağlar. Bu uygulama, kullanıcıların notlarını güvenli bir şekilde kaydedip yönetebileceği bir sistem sunar.

Kurulum
Veritabanı Yükleme

egenots.sql dosyasını MySQL veritabanınıza import edin. Bunu phpMyAdmin veya MySQL komut satırı aracılığıyla yapabilirsiniz.

SQL Event Oluşturma

IP adreslerini otomatik olarak temizlemek için aşağıdaki SQL komutlarını çalıştırın:
CREATE EVENT temizle_ip
ON SCHEDULE EVERY 1 HOUR
DO
  DELETE FROM ip
  WHERE zaman < NOW() - INTERVAL 1 HOUR;

Event Scheduler'ı Aktif Hale Getirme
Event'lerin çalışabilmesi için global event scheduler'ı aktif edin:

SET GLOBAL event_scheduler = ON;

Genel Bakış
Bu uygulama, kullanıcıların notlarını güvenli bir şekilde yönetebileceği bir online not alma sistemidir. Kullanıcılar, notlarına her yerden ve her zaman erişebilir ve düzenleyebilirler. Şifreler güvenli bir şekilde hashlenir ve kullanıcı bilgileri yönetici paneli aracılığıyla düzenlenebilir.

Özellikler
Kullanıcı Özellikleri
Şifre Güvenliği: Kullanıcı şifreleri veritabanında açık bir şekilde saklanmaz. Şifreler özel bir algoritma ile hashlenir.

Not Yönetimi: Kullanıcılar notlarını yazabilir, kaydedebilir, düzenleyebilir ve silebilir. Silinen notlar kalıcı olarak yok olur.

Kişisel Bilgiler: Kullanıcılar e-posta, doğum tarihi, adres ve telefon numarası bilgilerini güncelleyebilir veya kaldırabilirler. Ayrıca mevcut şifrelerini düzenleyebilirler.

Yönetici Özellikleri
Yetki Yönetimi: Kullanıcı hesaplarına yönetici yetkisi vermek için auth tablosundaki ilgili kolonu 0'dan 1'e çevirin.

Yenilikler Sayfası: Sistem güncellemelerini yönetici panelinden yayımlayabilir veya kaldırabilirsiniz.

Hesap Yönetimi: Kullanıcı hesaplarını aktif veya deaktif edebilirsiniz.

IP Adresi Yönetimi: Son 1 saat içinde siteye erişim sağlayan IP adreslerini görüntüleyebilir, yasaklayabilir veya yasaklarını kaldırabilirsiniz.

Destek Talepleri: Destek taleplerini görüntüleyebilir ve yanıtlayabilirsiniz.

Güvenlik Sistemi: Özel güvenlik sistemini aktif veya deaktif edebilirsiniz. Bu sistem, hesap girişinden sonra IP adresinde herhangi bir değişiklik algıladığında IP adresini otomatik olarak yasaklar.

Güvenlik ve Gizlilik
IP Adresi Güvenliği: IP adresleri yalnızca güvenlik amacıyla kullanılır ve kayıt altına alınmaz. Yasaklı IP adresleri haricinde hiçbir IP adresi 1 saatten fazla sitede kaydedilmez.

Veri Kayıt: Şifreler, IP adresleri ve diğer kullanıcı bilgileri güvenlik amacıyla titizlikle yönetilir ve kayıt altında tutulur.

SQL Event Ayarları
Sistem, IP adreslerini otomatik olarak temizlemek için SQL Event kullanır. Aşağıdaki kod, IP tablosundan bir saatten daha eski IP adreslerini siler:

CREATE EVENT temizle_ip
ON SCHEDULE EVERY 1 HOUR
DO
  DELETE FROM ip
  WHERE zaman < NOW() - INTERVAL 1 HOUR;

Event'in çalışabilmesi için global event scheduler'ı aktif hale getirin:
SET GLOBAL event_scheduler = ON;

Yönetim Paneli Notları
Performans: Yönetici paneline giriş hızı internet hızınıza bağlı olarak değişebilir. Sayfalar, API'lerden alınan verilerle dinamik olarak oluşturulur.

Local Test: Siteyi yerel (localhost) üzerinde çalıştırıyorsanız, IP adresiniz ::1 olarak tespit edilir. Bu, bazı API hatalarına yol açabilir. Sorunun önüne geçmek için, banned ve ip tablolarındaki ::1 IP adreslerini kaldırarak geçerli IP adreslerini manuel olarak ekleyebilirsiniz.

