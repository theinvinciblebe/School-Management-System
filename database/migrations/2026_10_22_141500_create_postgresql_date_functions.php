<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::unprepared("
                CREATE OR REPLACE FUNCTION year(d date) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(YEAR FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION year(d timestamp) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(YEAR FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION year(d timestamp with time zone) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(YEAR FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION month(d date) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(MONTH FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION month(d timestamp) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(MONTH FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION month(d timestamp with time zone) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(MONTH FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION day(d date) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(DAY FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION day(d timestamp) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(DAY FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;

                CREATE OR REPLACE FUNCTION day(d timestamp with time zone) RETURNS integer AS \$\$
                BEGIN
                    RETURN EXTRACT(DAY FROM d)::integer;
                END;
                \$\$ LANGUAGE plpgsql IMMUTABLE;
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::unprepared("
                DROP FUNCTION IF EXISTS year(date);
                DROP FUNCTION IF EXISTS year(timestamp);
                DROP FUNCTION IF EXISTS year(timestamp with time zone);
                DROP FUNCTION IF EXISTS month(date);
                DROP FUNCTION IF EXISTS month(timestamp);
                DROP FUNCTION IF EXISTS month(timestamp with time zone);
                DROP FUNCTION IF EXISTS day(date);
                DROP FUNCTION IF EXISTS day(timestamp);
                DROP FUNCTION IF EXISTS day(timestamp with time zone);
            ");
        }
    }
};
