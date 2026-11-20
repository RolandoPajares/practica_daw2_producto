<?php

class ProductoController extends Controller
{
    public function index(): void
    {
        $this->listar();
    }

    public function listar(): void
    {
        $this->views->render($this, 'listar', ['productos' => $this->model->listarConDetalle()]);
    }

    public function crear(): void
    {
        $this->views->render($this, 'formulario', $this->datosVistaFormulario());
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('productos');
        }

        
        $data = [
            'id_categoria' => (int) ($_POST['id_categoria'] ?? 0),
            'id_marca' => (int) ($_POST['id_marca'] ?? 0),
            'codigo' => trim($_POST['codigo'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => $_POST['precio'] ?? '',
            'stock' => $_POST['stock'] ?? '',
            'unidad_medida' => trim($_POST['unidad_medida'] ?? ''),
            'fecha_registro' => $_POST['fecha_registro'] ?? '',
            'estado' => 1
        ];

        if (!$this->datosValidos($data)) {
            $vista = $this->datosVistaFormulario($_POST);
            $vista['error'] = 'Complete correctamente todos los campos obligatorios.';
            $this->views->render($this, 'formulario', $vista);
            return;
        }

        $this->model->insert($data);
        redirect('productos');
    }

    public function editar($id): void
    {
        $producto = $this->model->find((int) $id);
        if (!$producto) {
            $this->notFound();
            return;
        }
        $this->views->render($this, 'formulario', $this->datosVistaFormulario($producto, 'productos/actualizar/' . (int) $id, 'Editar producto'));
    }

    public function actualizar($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('productos');
        }
        $data = $this->datosFormulario();
        if ($data === null) {
            $vista = $this->datosVistaFormulario($_POST, 'productos/actualizar/' . (int) $id, 'Editar producto');
            $vista['error'] = 'Complete correctamente todos los campos obligatorios.';
            $this->views->render($this, 'formulario', $vista);
            return;
        }
        $this->model->update((int) $id, $data);
        redirect('productos');
    }

    public function eliminar($id): void
    {
        $this->model->update((int) $id, ['estado' => 0]);
        redirect('productos');
    }

    private function datosVistaFormulario(array $producto = [], string $action = 'productos/guardar', string $title = 'Registrar producto'): array
    {
        require_once 'Models/CategoriaModel.php';
        require_once 'Models/MarcaModel.php';
        return [
            'producto' => $producto,
            'categorias' => (new CategoriaModel())->activas(),
            'marcas' => (new MarcaModel())->activas(),
            'action' => $action,
            'title' => $title
        ];
    }

    private function datosFormulario(): ?array
    {
        $idCategoria = (int) ($_POST['id_categoria'] ?? 0);
        $idMarca = (int) ($_POST['id_marca'] ?? 0);
        $codigo = trim($_POST['codigo'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = $_POST['precio'] ?? '';
        $stock = $_POST['stock'] ?? '';
        $unidad = trim($_POST['unidad_medida'] ?? '');
        $fecha = $_POST['fecha_registro'] ?? '';
        $categoria = $this->maestroActivo('CategoriaModel', $idCategoria);
        $marca = $this->maestroActivo('MarcaModel', $idMarca);
        $valido = $categoria && $marca && $codigo !== '' && $nombre !== '' && $unidad !== ''
            && is_numeric($precio) && (float) $precio >= 0 && filter_var($stock, FILTER_VALIDATE_INT) !== false
            && (int) $stock >= 0 && preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha);
        if (!$valido) return null;
        return [
            'id_categoria' => $idCategoria,
            'id_marca' => $idMarca,
            'codigo' => $codigo,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => (int) $stock,
            'unidad_medida' => $unidad,
            'fecha_registro' => $fecha,
            'estado' => 1
        ];
    }

    private function datosValidos(array $data): bool
    {
        $categoria = $this->maestroActivo('CategoriaModel', (int) $data['id_categoria']);
        $marca = $this->maestroActivo('MarcaModel', (int) $data['id_marca']);

        return $categoria && $marca
            && $data['codigo'] !== ''
            && $data['nombre'] !== ''
            && $data['unidad_medida'] !== ''
            && is_numeric($data['precio'])
            && (float) $data['precio'] >= 0
            && filter_var($data['stock'], FILTER_VALIDATE_INT) !== false
            && (int) $data['stock'] >= 0
            && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['fecha_registro']);
    }

    private function maestroActivo(string $modelName, int $id): ?array
    {
        $file = 'Models/' . $modelName . '.php';
        require_once $file;
        return (new $modelName())->where(['id = :id', 'estado = :estado'], ['id' => $id, 'estado' => 1])->first();
    }

    private function notFound(): void
    {
        require_once 'Controllers/ErrorController.php';
        (new ErrorController())->error404();
    }
}
