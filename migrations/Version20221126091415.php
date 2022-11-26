<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126091415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cart_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE order_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, session_id VARCHAR(40) NOT NULL, dt_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, dt_update TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE cart IS \'Корзины пользователей\'');
        $this->addSql('COMMENT ON COLUMN cart.session_id IS \'Идентификатор сессии\'');
        $this->addSql('COMMENT ON COLUMN cart.dt_create IS \'Дата создания корзины\'');
        $this->addSql('COMMENT ON COLUMN cart.dt_update IS \'Дата обновления корзины\'');
        $this->addSql('CREATE TABLE cart_product (id INT NOT NULL, product_id INT DEFAULT NULL, cart_id INT DEFAULT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2890CCAA4584665A ON cart_product (product_id)');
        $this->addSql('CREATE INDEX IDX_2890CCAA1AD5CDBF ON cart_product (cart_id)');
        $this->addSql('COMMENT ON TABLE cart_product IS \'Товары в корзине\'');
        $this->addSql('COMMENT ON COLUMN cart_product.quantity IS \'Количество товаров\'');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, status_id INT NOT NULL, session_id VARCHAR(40) NOT NULL, total_price DOUBLE PRECISION NOT NULL, email VARCHAR(180) NOT NULL, dt_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F52993986BF700BD ON "order" (status_id)');
        $this->addSql('COMMENT ON TABLE "order" IS \'Заказы\'');
        $this->addSql('COMMENT ON COLUMN "order".status_id IS \'Связь со статусами\'');
        $this->addSql('COMMENT ON COLUMN "order".session_id IS \'Идентификатор сессии\'');
        $this->addSql('COMMENT ON COLUMN "order".total_price IS \'Итоговая стоимоть заказа\'');
        $this->addSql('COMMENT ON COLUMN "order".email IS \'Email получателя\'');
        $this->addSql('COMMENT ON COLUMN "order".dt_create IS \'Дата создания заказа\'');
        $this->addSql('CREATE TABLE order_status (id INT NOT NULL, value VARCHAR(30) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE order_status IS \'Справочник статусов заказа\'');
        $this->addSql('COMMENT ON COLUMN order_status.value IS \'Значение\'');
        $this->addSql('COMMENT ON COLUMN order_status.description IS \'Описание\'');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, price DOUBLE PRECISION NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, author VARCHAR(180) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE product IS \'Товары\'');
        $this->addSql('COMMENT ON COLUMN product.price IS \'Стоимость товара\'');
        $this->addSql('COMMENT ON COLUMN product.title IS \'Наименование товара\'');
        $this->addSql('COMMENT ON COLUMN product.description IS \'Описание товара\'');
        $this->addSql('COMMENT ON COLUMN product.author IS \'Автор\'');
        $this->addSql('COMMENT ON COLUMN product.image IS \'Ссылка на изображение товара\'');
        $this->addSql('COMMENT ON COLUMN product.url IS \'Ссылка для скачивания\'');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cart_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE order_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('ALTER TABLE cart_product DROP CONSTRAINT FK_2890CCAA4584665A');
        $this->addSql('ALTER TABLE cart_product DROP CONSTRAINT FK_2890CCAA1AD5CDBF');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993986BF700BD');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE product');
    }
}
