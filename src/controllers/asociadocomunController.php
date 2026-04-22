<?php
namespace App\Controllers;
use App\Repositories\asociadoComunRepository;
use App\Models\asociadoComunModel;
use App\Repositories\callacenterRepository;
class AsociadoComunController
{
    public static function Home()
    {
        \Utils\AuthHelper::requireAuth(12);
        return [
            'view' => 'asociadoComun/home.php',
            'scripts' => 'asociadoComun',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
        \Utils\AuthHelper::requireAuth(12);
        return [
            'view' => 'asociadoComun/home.php',
            'scripts' => 'asociadoComun',
            'action' => 'content',
            'data' => [
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }
        public static function serviAran(){
        \Utils\AuthHelper::requireAuth(12);
        return [
            'view' => 'asociadoComun/home.php',
            'scripts' => 'asociadoComun',
            'action' => 'serviAran',
            'data' => [
                'title' => 'Servicios Arancelarios',
                'subtitle' => 'Consulta nuestros servicios arancelarios disponibles',
                'icon' => 'mdi mdi-scale-balance',
            ]
        ];
    }

    public static function serviJuri(){
        \Utils\AuthHelper::requireAuth(12);
        return [
            'view' => 'asociadoComun/home.php',
            'scripts' => 'asociadoComun',
            'action' => 'serviJuri',
            'data' => [
                'title' => 'Servicios Jurídicos',
                'subtitle' => 'Consulta nuestros servicios legales y asesoría especializada',
                'icon' => 'mdi mdi-gavel',
            ]
        ];
    }
    public static function Avisos(){
    \Utils\AuthHelper::requireAuth(12);
     $modalListAsociado = callacenterRepository::getModalListAsociado();
     $countAvisos = callacenterRepository::countActiveAvisos();
     return [
            'view' => 'asociadoComun/home.php',
            'scripts' => 'asociadoComun',
            'action' => 'aviso',
            'data' => [
                'title' => 'Avisos',
                'subtitle' => 'Tienes ' . $countAvisos . ' avisos activos',
                'button' => 'Agregar nuevo aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'modal' => $modalListAsociado,
        ];
        }

 public static function contacto(){
    \Utils\AuthHelper::requireAuth(12);
     return [
            'view' => 'asociadoComun/home.php',
            'scripts' => 'asociadoComun',
            'action' => 'contacto',
            'data' => [
                'title' => 'Contacto',
                'subtitle' => 'Contáctanos para cualquier duda o soporte',
                'button' => 'Enviar mensaje',
                'icon' => 'mdi mdi-email-outline',
            ],
        ];
 }
 public static function convenio(){
    \Utils\AuthHelper::requireAuth(12);
     return [
            'view' => 'asociadoComun/home.php',
            'scripts' => 'asociadoComun',
            'action' => 'convenio',
            'data' => [
                'title' => 'Convenios',
                'subtitle' => 'Consulta nuestros convenios y beneficios exclusivos para asociados',
                'button' => 'Ver convenios disponibles',
                'icon' => 'mdi mdi-handshake-outline',
            ],
        ];

 }
}