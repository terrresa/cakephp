<?php
namespace App\Controller;
use Cake\Validation\Validator;

class UsuariosController extends AuthController{
    
    public function initialize() {
        parent::initialize();
        $this->loadModel('Roles');
    }
    
    public function index() {
        $usuarios = $this->Usuarios->find()->contain(['Roles']);
        $this->set('usuarios', $usuarios);
    }
    
    public function registrar() {
        $usuario = $this->Usuarios->newEntity();
        if($this->request->is('POST')){
            
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            if($this->Usuarios->save($usuario)){
                $this->Flash->success('Registro guardado correctamente');
                $this->redirect(['action'=>'index']);
            }else{
                $this->Flash->error('Error al momento de guardar el registro');
            }
        }
        $this->set('usuario', $usuario);
        
        $roles = $this->Roles->find('list'); // list: ideal para poblar combos
        $this->set('roles', $roles);
    }
    
    public function editar($id) {
        $usuario = $this->Usuarios->get($id);
        if($this->request->is('put')){ // or post <form>
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            if( $this->Usuarios->save($usuario) ) {
                $this->Flash->success('Registro guardado correctamente');
                $this->redirect(['action'=>'index']);
            } else {
                $this->Flash->error('Error al momento de guardar el registro');
            }
        }
        $this->set('usuario', $usuario);
        
        $query = $this->Roles->find('list');
        $this->set('roles', $query);
    }
    
    public function eliminar($id) {
        $usuario = $this->Usuarios->get($id);
        if( $this->Usuarios->delete($usuario) ) {
            $this->Flash->success('Registro eliminado correctamente');
        } else {
            $this->Flash->error('Error al momento de eliminar el registro');
        }
        $this->redirect(['action'=>'index']);
    }

    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Usuario y/o clave inválido');
        }
        
        $this->viewBuilder()->layout('default_public');
    }
    
        public function validationDefault(Validator $validator){
      
           $validator->notEmpty('username', 'Nombre de usuario obligatorio')
            ->minLength('username',8,'tamaño debe ser de 8 caracteres')       
            ->email('email', false, 'Correo invalido')                
            ->notEmpty('password', 'Password obligatorio')
            ->notEmpty('role', 'Rol obligatorio');
        
          return $validator;
    }

    
    public function logout(){
        return $this->redirect($this->Auth->logout());
    }
    
}
