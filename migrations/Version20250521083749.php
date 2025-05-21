<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521083749 extends AbstractMigration{
    public function getDescription(): string{
        return '';
    }

    public function up(Schema $schema): void{
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.available_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
                BEGIN
                    PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                    RETURN NEW;
                END;
            $$ LANGUAGE plpgsql;
        SQL);
        $this->addSql(<<<'SQL'
            DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER brand SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER brand TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER model SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER model TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER color SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER color TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER price TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER price SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER stock_quantity SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_brand SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_brand TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_model SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_model TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_price TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_price SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_color SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_color TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_name SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_name TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_phone SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_phone TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER username SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER email SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER password SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER phone SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER phone TYPE VARCHAR(20)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER role SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER role TYPE VARCHAR(20)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6DF44926F85E0677 ON userinfo (username)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6DF44926E7927C74 ON userinfo (email)
        SQL);
    }

    public function down(Schema $schema): void{
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql(<<<'SQL'
        //     CREATE SCHEMA public
        // SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_brand DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_brand TYPE VARCHAR(100)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_model DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_model TYPE VARCHAR(100)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_color DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_color TYPE VARCHAR(50)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_price TYPE INT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER car_price DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_name DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_name TYPE VARCHAR(100)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_phone DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carsales ALTER client_phone TYPE VARCHAR(11)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER brand DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER brand TYPE VARCHAR(100)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER model DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER model TYPE VARCHAR(100)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER color DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER color TYPE VARCHAR(50)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER price TYPE INT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER price DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars_inventory ALTER stock_quantity DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_6DF44926F85E0677
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_6DF44926E7927C74
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER username DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER email DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER password DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER phone DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER phone TYPE VARCHAR(15)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER role DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE userinfo ALTER role TYPE VARCHAR(50)
        SQL);
    }
}
