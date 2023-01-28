<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128092052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE acquiring_settings (id SERIAL NOT NULL, payment_type_id INT NOT NULL, login VARCHAR(80) NOT NULL, password VARCHAR(80) NOT NULL, is_active BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5AE547DADC058279 ON acquiring_settings (payment_type_id)');
        $this->addSql('COMMENT ON COLUMN acquiring_settings.id IS \'Идентификатор статуса заказа\'');
        $this->addSql('COMMENT ON COLUMN acquiring_settings.payment_type_id IS \'Идентификатор типа оплаты\'');
        $this->addSql('COMMENT ON COLUMN acquiring_settings.login IS \'Логин для авторизации у мерчанта\'');
        $this->addSql('COMMENT ON COLUMN acquiring_settings.password IS \'Пароль для авторизации у мерчанта\'');
        $this->addSql('COMMENT ON COLUMN acquiring_settings.is_active IS \'true — активный мерчант\'');
        $this->addSql('CREATE TABLE cart (id SERIAL NOT NULL, session_id VARCHAR(40) NOT NULL, dt_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, dt_update TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN cart.id IS \'Идентификатор корзины\'');
        $this->addSql('COMMENT ON COLUMN cart.session_id IS \'Идентификатор сессии\'');
        $this->addSql('COMMENT ON COLUMN cart.dt_create IS \'Дата создания корзины\'');
        $this->addSql('COMMENT ON COLUMN cart.dt_update IS \'Дата обновления корзины\'');
        $this->addSql('CREATE TABLE cart_product (id SERIAL NOT NULL, product_id INT DEFAULT NULL, cart_id INT DEFAULT NULL, quantity INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2890CCAA4584665A ON cart_product (product_id)');
        $this->addSql('CREATE INDEX IDX_2890CCAA1AD5CDBF ON cart_product (cart_id)');
        $this->addSql('COMMENT ON COLUMN cart_product.id IS \'Идентификатор товара в корзине\'');
        $this->addSql('COMMENT ON COLUMN cart_product.product_id IS \'Идентификатор товара\'');
        $this->addSql('COMMENT ON COLUMN cart_product.cart_id IS \'Идентификатор корзины\'');
        $this->addSql('COMMENT ON COLUMN cart_product.quantity IS \'Количество товаров\'');
        $this->addSql('CREATE TABLE check_type (id SERIAL NOT NULL, value VARCHAR(30) NOT NULL, description VARCHAR(255) DEFAULT NULL, code VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN check_type.id IS \'Идентификатор типа чека\'');
        $this->addSql('COMMENT ON COLUMN check_type.value IS \'Значение\'');
        $this->addSql('COMMENT ON COLUMN check_type.description IS \'Описание\'');
        $this->addSql('COMMENT ON COLUMN check_type.code IS \'Код типа чека\'');
        $this->addSql('CREATE TABLE history_order_status (id SERIAL NOT NULL, status_id INT NOT NULL, order_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C7F86326BF700BD ON history_order_status (status_id)');
        $this->addSql('CREATE INDEX IDX_8C7F86328D9F6D38 ON history_order_status (order_id)');
        $this->addSql('COMMENT ON COLUMN history_order_status.id IS \'Идентификатор в истории статуса заказа\'');
        $this->addSql('COMMENT ON COLUMN history_order_status.status_id IS \'Идентификатор статуса заказа\'');
        $this->addSql('COMMENT ON COLUMN history_order_status.order_id IS \'Идентификатор заказа\'');
        $this->addSql('CREATE TABLE image (id SERIAL NOT NULL, product_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C53D045F4584665A ON image (product_id)');
        $this->addSql('COMMENT ON COLUMN image.id IS \'Идентификатор изображения\'');
        $this->addSql('COMMENT ON COLUMN image.product_id IS \'Идентификатор товара\'');
        $this->addSql('COMMENT ON COLUMN image.file_name IS \'Наименование файла изображения\'');
        $this->addSql('COMMENT ON COLUMN image.path IS \'Путь до изображения\'');
        $this->addSql('COMMENT ON COLUMN image.description IS \'Описание\'');
        $this->addSql('CREATE TABLE "order" (id SERIAL NOT NULL, recipient_id INT NOT NULL, session_id VARCHAR(40) NOT NULL, total_price DOUBLE PRECISION DEFAULT \'0\' NOT NULL, dt_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F5299398E92F8F78 ON "order" (recipient_id)');
        $this->addSql('COMMENT ON COLUMN "order".id IS \'Идентификатор заказа\'');
        $this->addSql('COMMENT ON COLUMN "order".recipient_id IS \'Идентификатор получателя\'');
        $this->addSql('COMMENT ON COLUMN "order".session_id IS \'Идентификатор сессии\'');
        $this->addSql('COMMENT ON COLUMN "order".total_price IS \'Итоговая стоимость заказа\'');
        $this->addSql('COMMENT ON COLUMN "order".dt_create IS \'Дата/время создания заказа\'');
        $this->addSql('CREATE TABLE order_product (id SERIAL NOT NULL, product_id INT DEFAULT NULL, order_id INT NOT NULL, quantity INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2530ADE64584665A ON order_product (product_id)');
        $this->addSql('CREATE INDEX IDX_2530ADE68D9F6D38 ON order_product (order_id)');
        $this->addSql('COMMENT ON COLUMN order_product.id IS \'Идентификатор товара в заказе\'');
        $this->addSql('COMMENT ON COLUMN order_product.product_id IS \'Идентификатор товара\'');
        $this->addSql('COMMENT ON COLUMN order_product.order_id IS \'Идентификатор заказа\'');
        $this->addSql('COMMENT ON COLUMN order_product.quantity IS \'Количество товаров\'');
        $this->addSql('CREATE TABLE order_status (id SERIAL NOT NULL, value VARCHAR(30) NOT NULL, description VARCHAR(255) DEFAULT NULL, code VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN order_status.id IS \'Идентификатор статуса заказа\'');
        $this->addSql('COMMENT ON COLUMN order_status.value IS \'Значение\'');
        $this->addSql('COMMENT ON COLUMN order_status.description IS \'Описание\'');
        $this->addSql('COMMENT ON COLUMN order_status.code IS \'Код статуса\'');
        $this->addSql('CREATE TABLE payment (id SERIAL NOT NULL, payment_type_id INT NOT NULL, sum DOUBLE PRECISION NOT NULL, dt_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840DDC058279 ON payment (payment_type_id)');
        $this->addSql('COMMENT ON COLUMN payment.id IS \'Идентификатор оплаты\'');
        $this->addSql('COMMENT ON COLUMN payment.payment_type_id IS \'Идентификатор типа оплаты\'');
        $this->addSql('COMMENT ON COLUMN payment.sum IS \'Сумма оплаты\'');
        $this->addSql('COMMENT ON COLUMN payment.dt_create IS \'Дата/время создания оплаты\'');
        $this->addSql('CREATE TABLE payment_check (id SERIAL NOT NULL, check_type_id INT NOT NULL, payment_id INT NOT NULL, external_id VARCHAR(40) DEFAULT NULL, is_active BOOLEAN DEFAULT true NOT NULL, is_error BOOLEAN DEFAULT false NOT NULL, error_message VARCHAR(255) DEFAULT NULL, dt_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6BC79AA18350C213 ON payment_check (check_type_id)');
        $this->addSql('CREATE INDEX IDX_6BC79AA14C3A3BB ON payment_check (payment_id)');
        $this->addSql('COMMENT ON COLUMN payment_check.id IS \'Идентификатор чека\'');
        $this->addSql('COMMENT ON COLUMN payment_check.check_type_id IS \'Идентификатор типа чека\'');
        $this->addSql('COMMENT ON COLUMN payment_check.payment_id IS \'Идентификатор оплаты\'');
        $this->addSql('COMMENT ON COLUMN payment_check.external_id IS \'Внешний идентификатор сервиса фискализации\'');
        $this->addSql('COMMENT ON COLUMN payment_check.is_active IS \'true — чек требует фискализации\'');
        $this->addSql('COMMENT ON COLUMN payment_check.is_error IS \'true — ошибка фискализации чека\'');
        $this->addSql('COMMENT ON COLUMN payment_check.error_message IS \'Текст ошибки фискализации\'');
        $this->addSql('COMMENT ON COLUMN payment_check.dt_create IS \'Дата/время создания чека\'');
        $this->addSql('CREATE TABLE payment_type (id SERIAL NOT NULL, value VARCHAR(30) NOT NULL, description VARCHAR(255) DEFAULT NULL, code VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN payment_type.id IS \'Идентификатор типа оплаты\'');
        $this->addSql('COMMENT ON COLUMN payment_type.value IS \'Значение\'');
        $this->addSql('COMMENT ON COLUMN payment_type.description IS \'Описание\'');
        $this->addSql('COMMENT ON COLUMN payment_type.code IS \'Код типа оплаты\'');
        $this->addSql('CREATE TABLE product (id SERIAL NOT NULL, price DOUBLE PRECISION NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, author VARCHAR(180) DEFAULT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN product.id IS \'Идентификатор товара\'');
        $this->addSql('COMMENT ON COLUMN product.price IS \'Стоимость товара\'');
        $this->addSql('COMMENT ON COLUMN product.title IS \'Наименование товара\'');
        $this->addSql('COMMENT ON COLUMN product.description IS \'Описание товара\'');
        $this->addSql('COMMENT ON COLUMN product.author IS \'Автор\'');
        $this->addSql('COMMENT ON COLUMN product.url IS \'Ссылка для скачивания\'');
        $this->addSql('CREATE TABLE recipient (id SERIAL NOT NULL, first_name VARCHAR(60) NOT NULL, email VARCHAR(120) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN recipient.id IS \'Идентификатор получателя\'');
        $this->addSql('COMMENT ON COLUMN recipient.first_name IS \'Имя получателя\'');
        $this->addSql('COMMENT ON COLUMN recipient.email IS \'Email получателя\'');
        $this->addSql('CREATE TABLE transaction (id SERIAL NOT NULL, order_id INT NOT NULL, payment_id INT DEFAULT NULL, uuid UUID NOT NULL, sum DOUBLE PRECISION NOT NULL, is_active BOOLEAN DEFAULT true NOT NULL, payment_link VARCHAR(255) DEFAULT NULL, external_id VARCHAR(80) DEFAULT NULL, payment_type_code VARCHAR(10) NOT NULL, dt_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D18D9F6D38 ON transaction (order_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D14C3A3BB ON transaction (payment_id)');
        $this->addSql('COMMENT ON COLUMN transaction.id IS \'Идентификатор транзакции\'');
        $this->addSql('COMMENT ON COLUMN transaction.order_id IS \'Идентификатор заказа\'');
        $this->addSql('COMMENT ON COLUMN transaction.payment_id IS \'Идентификатор оплаты\'');
        $this->addSql('COMMENT ON COLUMN transaction.uuid IS \'Идентификатор транзакции в формате UUID для мерчантов\'');
        $this->addSql('COMMENT ON COLUMN transaction.sum IS \'Сумма транзакции\'');
        $this->addSql('COMMENT ON COLUMN transaction.is_active IS \'true — активная транзакция (оплата не подтверждена)\'');
        $this->addSql('COMMENT ON COLUMN transaction.payment_link IS \'Ссылка для оплаты\'');
        $this->addSql('COMMENT ON COLUMN transaction.external_id IS \'Внешний идентификатор мерчанта\'');
        $this->addSql('COMMENT ON COLUMN transaction.payment_type_code IS \'Код типа оплаты\'');
        $this->addSql('COMMENT ON COLUMN transaction.dt_create IS \'Дата/время создания транзакции\'');
        $this->addSql('ALTER TABLE acquiring_settings ADD CONSTRAINT FK_5AE547DADC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_order_status ADD CONSTRAINT FK_8C7F86326BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_order_status ADD CONSTRAINT FK_8C7F86328D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398E92F8F78 FOREIGN KEY (recipient_id) REFERENCES recipient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment_check ADD CONSTRAINT FK_6BC79AA18350C213 FOREIGN KEY (check_type_id) REFERENCES check_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment_check ADD CONSTRAINT FK_6BC79AA14C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D18D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE acquiring_settings DROP CONSTRAINT FK_5AE547DADC058279');
        $this->addSql('ALTER TABLE cart_product DROP CONSTRAINT FK_2890CCAA4584665A');
        $this->addSql('ALTER TABLE cart_product DROP CONSTRAINT FK_2890CCAA1AD5CDBF');
        $this->addSql('ALTER TABLE history_order_status DROP CONSTRAINT FK_8C7F86326BF700BD');
        $this->addSql('ALTER TABLE history_order_status DROP CONSTRAINT FK_8C7F86328D9F6D38');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045F4584665A');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398E92F8F78');
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT FK_2530ADE64584665A');
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT FK_2530ADE68D9F6D38');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DDC058279');
        $this->addSql('ALTER TABLE payment_check DROP CONSTRAINT FK_6BC79AA18350C213');
        $this->addSql('ALTER TABLE payment_check DROP CONSTRAINT FK_6BC79AA14C3A3BB');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D18D9F6D38');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D14C3A3BB');
        $this->addSql('DROP TABLE acquiring_settings');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE check_type');
        $this->addSql('DROP TABLE history_order_status');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_product');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_check');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE recipient');
        $this->addSql('DROP TABLE transaction');
    }
}
