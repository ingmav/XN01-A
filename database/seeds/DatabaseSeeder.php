<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {     
        $this->call(ServidoresSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(PermisosSeeder::class);
        $this->call(RolesSeeder::class);

        //Carga de archivos CSV
        $lista_csv = [
            'msw_familia',
            'msw_proveedores',
            'msw_articulos'
        ];
        
        foreach($lista_csv as $csv){
            $archivo_csv = storage_path().'/app/seeds/'.$csv.'.csv';

            $query = sprintf("
                LOAD DATA local INFILE '%s' 
                INTO TABLE $csv 
                FIELDS TERMINATED BY ',' 
                OPTIONALLY ENCLOSED BY '\"' 
                ESCAPED BY '\"' 
                LINES TERMINATED BY '\\n' 
                IGNORE 1 LINES", addslashes($archivo_csv));
            echo $query;
            DB::connection()->getpdo()->exec($query);
        }   
    }
}
