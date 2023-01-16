<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115074441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE history_order_status (id SERIAL NOT NULL, status_id INT NOT NULL, order_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C7F86326BF700BD ON history_order_status (status_id)');
        $this->addSql('CREATE INDEX IDX_8C7F86328D9F6D38 ON history_order_status (order_id)');
        $this->addSql('COMMENT ON TABLE history_order_status IS \'История статусов заказа\'');
        $this->addSql('COMMENT ON COLUMN history_order_status.id IS \'Идентификатор в истории статуса заказа\'');
        $this->addSql('COMMENT ON COLUMN history_order_status.status_id IS \'Идентификатор статуса заказа\'');
        $this->addSql('COMMENT ON COLUMN history_order_status.order_id IS \'Идентификатор заказа\'');
        $this->addSql('CREATE TABLE order_product (id SERIAL NOT NULL, product_id INT DEFAULT NULL, order_id INT NOT NULL, quantity INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2530ADE64584665A ON order_product (product_id)');
        $this->addSql('CREATE INDEX IDX_2530ADE68D9F6D38 ON order_product (order_id)');
        $this->addSql('COMMENT ON TABLE order_product IS \'Товары в заказе\'');
        $this->addSql('COMMENT ON COLUMN order_product.id IS \'Идентификатор товара в заказе\'');
        $this->addSql('COMMENT ON COLUMN order_product.product_id IS \'Идентификатор товара\'');
        $this->addSql('COMMENT ON COLUMN order_product.order_id IS \'Идентификатор заказа\'');
        $this->addSql('COMMENT ON COLUMN order_product.quantity IS \'Количество товаров\'');
        $this->addSql('CREATE TABLE recipient (id SERIAL NOT NULL, first_name VARCHAR(60) NOT NULL, email VARCHAR(120) NOT NULL, session_id VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE recipient IS \'Получатели\'');
        $this->addSql('COMMENT ON COLUMN recipient.id IS \'Идентификатор получателя\'');
        $this->addSql('COMMENT ON COLUMN recipient.first_name IS \'Имя получателя\'');
        $this->addSql('COMMENT ON COLUMN recipient.email IS \'Email получателя\'');
        $this->addSql('COMMENT ON COLUMN recipient.session_id IS \'Идентификатор сессии\'');
        $this->addSql('ALTER TABLE history_order_status ADD CONSTRAINT FK_8C7F86326BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_order_status ADD CONSTRAINT FK_8C7F86328D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f52993986bf700bd');
        $this->addSql('DROP INDEX idx_f52993986bf700bd');
        $this->addSql('ALTER TABLE "order" ADD recipient_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP status_id');
        $this->addSql('ALTER TABLE "order" DROP email');
        $this->addSql('COMMENT ON COLUMN "order".recipient_id IS \'Идентификатор получателя\'');
        $this->addSql('COMMENT ON COLUMN "order".total_price IS \'Итоговая стоимость заказа\'');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398E92F8F78 FOREIGN KEY (recipient_id) REFERENCES recipient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F5299398E92F8F78 ON "order" (recipient_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398E92F8F78');
        $this->addSql('ALTER TABLE history_order_status DROP CONSTRAINT FK_8C7F86326BF700BD');
        $this->addSql('ALTER TABLE history_order_status DROP CONSTRAINT FK_8C7F86328D9F6D38');
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT FK_2530ADE64584665A');
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT FK_2530ADE68D9F6D38');
        $this->addSql('DROP TABLE history_order_status');
        $this->addSql('DROP TABLE order_product');
        $this->addSql('DROP TABLE recipient');
        $this->addSql('DROP INDEX IDX_F5299398E92F8F78');
        $this->addSql('ALTER TABLE "order" ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD email VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" DROP recipient_id');
        $this->addSql('COMMENT ON COLUMN "order".status_id IS \'Связь со статусами\'');
        $this->addSql('COMMENT ON COLUMN "order".email IS \'Email получателя\'');
        $this->addSql('COMMENT ON COLUMN "order".total_price IS \'Итоговая стоимоть заказа\'');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f52993986bf700bd FOREIGN KEY (status_id) REFERENCES order_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f52993986bf700bd ON "order" (status_id)');
    }
}
