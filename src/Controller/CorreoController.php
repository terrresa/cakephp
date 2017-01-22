<?php
namespace App\Controller;

use Cake\Mailer\Email;

class CorreoController extends AuthController{
    
    public function index() {
        $email = new Email('default'); // Seleccionar el profile a usar
        $email->from(['noreply@tecsup.edu.pe' => 'Tienda Online'])
            ->to('miqueridatechi@gmail.com')
            ->subject('Contacto desde tienda online')
            ->send('Contenido del correo ...');
        
       $this->Flash->success('correo enviado satisfactoriamente');
       return $this->redirect(['controller' => 'home','action'=>'index']); // Solo para este ejemplo no se usará una vista
    }

    
    
    
   
    
}
