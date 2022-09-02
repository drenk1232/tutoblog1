<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rol;
use App\Models\Usuario;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Instalador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutoblog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando ejecuta el instalador inicial del proyecto';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!$this->verificar()){
            $rol = $this->crearRolSuperAdmin();
            $usuario = $this->crearUsuarioSuperAdmin();
            $usuario ->roles()->attach($rol);
            $this->line('El Rol y Usuario Administrador se instalaron correctamente');
        }else{
            $this->error('No se puede ejecutar el instalador, porque ya hay un rol creado');
        }
    }

    private function verificar(){
        return Rol::find(1);
    }

    private function crearRolSuperAdmin(){
        $rol = 'Super Administrador';
        return Rol::create([
            'nombre'=>$rol,
            'slug'=>Str::slug($rol,'_')
    ]);
    }

    private function crearUsuarioSuperAdmin(){
        return Usuario::create([
            'nombre'=>'tutoadmin',
            'email'=>'rgt98@gmail.com',
            'password'=>Hash::make('123456789'),
            'estado'=>1,
        ]);

    }
}
