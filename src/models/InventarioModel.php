<?php

namespace App\Models;

use App\Models\EntityModel;

class InventarioModel extends EntityModel
{
    protected $table = "inventario";
    protected $alias = "i";
    
    // Cambia PRIVATE por PROTECTED y agrega las propiedades faltantes
    protected ?int $id = null;
    protected string $nombre = '';
    protected string $cantidad = '';
    protected string $descripcion = '';
    protected string $fecha_ingreso = '';
    
    // AGREGA estas propiedades que faltan
    protected ?string $created_at = null;
    protected ?string $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
    public function getCantidad(): string
    {
        return $this->cantidad;
    }
    public function setCantidad(string $cantidad): void
    {
        $this->cantidad = $cantidad;
    }
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }
    public function getFechaIngreso(): ?string
    {
        return $this->fecha_ingreso;
    }
    public function setFechaIngreso(string $fecha_ingreso): void
    {
        $this->fecha_ingreso = $fecha_ingreso;
    }

    // AGREGA los getters y setters para las nuevas propiedades
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
    
    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }
    
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
    
    public function setUpdatedAt(?string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /*metodo para obtener los productos */
    public function obtenerProductos(): array
    {
        return $this->select("*", [], false);
    }

    public function aumentarCantidad(int $id, int $cantidad): bool
    {
        $setClause = "cantidad = cantidad + :cantidad";
        $options = [
            'where' => 'id = :id',
            'replaces' => [
                ':cantidad' => $cantidad,
                ':id' => $id,
            ]
        ];

        $this->update($id, $setClause, $options);
        return true;
    }
    
    public function disminuirCantidad(int $id, int $cantidad): bool
    {
        $setClause = "cantidad = cantidad - :cantidad";
        $options = [
            'where' => 'id = :id',
            'replaces' => [
                ':cantidad' => $cantidad,
                ':id' => $id,
            ]
        ];

        $this->update($id, $setClause, $options);
        return true;
    }

    // ELIMINA el método insert() duplicado o modifícalo si necesitas lógica especial
    public function insert()
    {
        // Si necesitas lógica especial para fecha_ingreso, hazlo antes de llamar al parent
        if (empty($this->fecha_ingreso)) {
            $this->fecha_ingreso = date('Y-m-d H:i:s');
        }
        
        // Llama al insert del EntityModel
        parent::insert();
    }
}