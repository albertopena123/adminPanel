<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SigaSifController extends Controller
{
    /**
     * Muestra el catálogo de bienes y servicios.
     */
    public function catalogoIndex(Request $request)
    {
        // Capturar parámetros de filtrado
        $search = $request->input('search', '');
        $tipoBien = $request->input('tipo_bien', '');
        $estado = $request->input('estado', '');

        // Construir la consulta base
        $query = DB::connection('siga_sqlsrv')
            ->table('CATALOGO_BIEN_SERV AS CS')
            ->join('SIG_UNIDAD_MEDIDA_TIPO AS UM', function ($join) {
                $join->on('CS.UNIDAD_MEDIDA', '=', 'UM.UNIDAD_MEDIDA')
                    ->on('CS.UNIDAD_ADQUIS', '=', 'UM.UNIDAD_MEDIDA');
            })
            ->select(
                'CS.CODIGO_ITEM',
                'CS.TIPO_BIEN',
                'CS.GRUPO_BIEN',
                'CS.CLASE_BIEN',
                'CS.FAMILIA_BIEN',
                'CS.ITEM_BIEN',
                'CS.NOMBRE_ITEM',
                'CS.UNIDAD_ADQUIS',
                'UM.NOMBRE AS NOMBRE_UNIDAD',
                'CS.PRESENTACION',
                'CS.PRECIO_COMPRA',
                'CS.ESTADO',
                'CS.ESTADO_MEF'
            )
            ->whereIn('CS.TIPO_BIEN', ['S', 'B']); //

        // Aplicar filtros si están presentes
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('CS.NOMBRE_ITEM', 'LIKE', '%' . $search . '%')
                    ->orWhere('CS.CODIGO_ITEM', 'LIKE', '%' . $search . '%');
            });
        }

        if (!empty($tipoBien)) {
            $query->where('CS.TIPO_BIEN', '=', $tipoBien);
        }

        if (!empty($estado)) {
            $query->where('CS.ESTADO_MEF', '=', $estado);
        }

        // Obtener resultados paginados (15 por página)
        $catalogo = $query->orderBy('CS.CODIGO_ITEM')->paginate(15);

        // Obtener lista de tipos de bienes para el filtro
        $tiposBien = [
            (object)['TIPO_BIEN' => 'B', 'DESCRIPCION' => 'Bien'],
            (object)['TIPO_BIEN' => 'S', 'DESCRIPCION' => 'Servicio']
        ];

        return view('admin.siga.catalogo.index', compact('catalogo', 'tiposBien', 'search', 'tipoBien', 'estado'));
    }

    /**
     * Muestra el formulario para actualizar bienes.
     */
    public function bienesUpdateForm()
    {
        return view('siga.bienes.update');
    }

    /**
     * Procesa la actualización de bienes.
     */
    public function bienesUpdate(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'grupo_bien' => 'required',
            'clase_bien' => 'required',
            'familia_bien' => 'required',
            'item_bien' => 'required'
        ]);

        // Actualiza el registro en la base de datos siga_130
        DB::connection('siga_sqlsrv')->update(
            '
            UPDATE CATALOGO_BIEN_SERV
            SET estado_mef=?, TIPO_ACTIVO=?, ANO_ORDEN=?, NRO_ORDEN=?, TIPO_PPTO=?, FECHA_COMPRA=?
            WHERE GRUPO_BIEN=? and CLASE_BIEN=? and FAMILIA_BIEN=? and ITEM_BIEN=?',
            [
                $request->estado_mef,
                $request->tipo_activo,
                $request->ano_orden,
                $request->nro_orden,
                $request->tipo_ppto,
                $request->fecha_compra,
                $request->grupo_bien,
                $request->clase_bien,
                $request->familia_bien,
                $request->item_bien
            ]
        );

        // Registra la actividad usando la base de datos principal (adminpanel)
        // Esto es opcional, pero demuestra cómo usar ambas conexiones en el mismo método
        DB::table('activity_log')->insert([
            'description' => 'Actualización de bien SIGA',
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('siga.bienes.update')->with('success', 'Bien actualizado correctamente.');
    }

    /**
     * Muestra el formulario para modificar el catálogo.
     */
    public function catalogoModifyForm()
    {
        return view('siga.catalogo.modify');
    }

    /**
     * Procesa la modificación del catálogo.
     */
    public function catalogoModify(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre_item' => 'required',
            'estado' => 'required'
        ]);

        // Actualiza el registro en la base de datos siga_130
        DB::connection('siga_sqlsrv')->update(
            '
            UPDATE CATALOGO_BIEN_SERV_ORIGINAL
            SET estado=?
            WHERE NOMBRE_ITEM=?',
            [$request->estado, $request->nombre_item]
        );

        return redirect()->route('siga.catalogo.modify')->with('success', 'Catálogo modificado correctamente.');
    }

    /**
     * Muestra las unidades de medida.
     */
    public function unidadesIndex()
    {
        $unidades = DB::connection('siga_sqlsrv')->select('SELECT * FROM SIG_UNIDAD_MEDIDA_TIPO');

        return view('siga.unidades.index', compact('unidades'));
    }

    /**
     * Muestra el formulario para crear una unidad de medida.
     */
    public function unidadesCreate()
    {
        return view('siga.unidades.create');
    }

    /**
     * Almacena una nueva unidad de medida.
     */
    public function unidadesStore(Request $request)
    {
        // Implementar lógica para almacenar
        return redirect()->route('siga.unidades.index')->with('success', 'Unidad de medida creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una unidad de medida.
     */
    public function unidadesEdit($id)
    {
        $unidad = DB::connection('siga_sqlsrv')->select(
            'SELECT * FROM SIG_UNIDAD_MEDIDA_TIPO WHERE UNIDAD_MEDIDA = ?',
            [$id]
        );

        if (empty($unidad)) {
            return redirect()->route('siga.unidades.index')->with('error', 'Unidad de medida no encontrada.');
        }

        $unidad = $unidad[0]; // Obtener el primer registro

        return view('siga.unidades.edit', compact('unidad'));
    }

    /**
     * Actualiza una unidad de medida.
     */
    public function unidadesUpdate(Request $request, $id)
    {
        // Implementar lógica para actualizar
        return redirect()->route('siga.unidades.index')->with('success', 'Unidad de medida actualizada correctamente.');
    }

    /**
     * Elimina una unidad de medida.
     */
    public function unidadesDestroy($id)
    {
        // Implementar lógica para eliminar
        return redirect()->route('siga.unidades.index')->with('success', 'Unidad de medida eliminada correctamente.');
    }

    /**
     * Muestra el panel de administración completo de SIGA.
     */
    public function adminPanel()
    {
        // Puedes combinar datos de ambas bases de datos
        $catalogoCount = DB::connection('siga_sqlsrv')->table('CATALOGO_BIEN_SERV')->count();
        $unidadesCount = DB::connection('siga_sqlsrv')->table('SIG_UNIDAD_MEDIDA_TIPO')->count();

        // También puedes acceder a datos de la base de datos principal (adminpanel)
        $usersWithSigaPermission = DB::table('users')
            ->join('permission_role', 'users.role_id', '=', 'permission_role.role_id')
            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
            ->where('permissions.slug', 'like', '%siga%')
            ->distinct()
            ->count('users.id');

        return view('siga.admin', compact('catalogoCount', 'unidadesCount', 'usersWithSigaPermission'));
    }


    /**
     * Actualiza los estados de un ítem del catálogo mediante modal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEstados(Request $request, $id)
    {
        try {
            // Validación de datos
            $validated = $request->validate([
                'estado' => 'required|in:A,I',
                'estado_mef' => 'required|in:A,I',
                'grupo_bien' => 'required',
                'clase_bien' => 'required',
                'familia_bien' => 'required',
                'item_bien' => 'required'
            ]);

            // Actualizar el ESTADO y ESTADO_MEF en CATALOGO_BIEN_SERV
            $affectedRows = DB::connection('siga_sqlsrv')->update(
                'UPDATE CATALOGO_BIEN_SERV
                 SET ESTADO = ?, ESTADO_MEF = ?
                 WHERE GRUPO_BIEN = ? AND CLASE_BIEN = ? AND FAMILIA_BIEN = ? AND ITEM_BIEN = ?',
                [
                    $request->estado,
                    $request->estado_mef,
                    $request->grupo_bien,
                    $request->clase_bien,
                    $request->familia_bien,
                    $request->item_bien
                ]
            );

            // También actualizar ESTADO en CATALOGO_BIEN_SERV_ORIGINAL si existe
            DB::connection('siga_sqlsrv')->update(
                'UPDATE CATALOGO_BIEN_SERV_ORIGINAL
                 SET ESTADO = ?
                 WHERE GRUPO_BIEN = ? AND CLASE_BIEN = ? AND FAMILIA_BIEN = ? AND ITEM_BIEN = ?',
                [
                    $request->estado,
                    $request->grupo_bien,
                    $request->clase_bien,
                    $request->familia_bien,
                    $request->item_bien
                ]
            );

            // Verificar si se actualizó correctamente
            if ($affectedRows > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Los estados del ítem ' . $id . ' han sido actualizados correctamente.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el ítem o no fue necesario actualizarlo.'
                ]);
            }
        } catch (\Exception $e) {
            // Capturar cualquier error y devolver un mensaje claro
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al actualizar los estados: ' . $e->getMessage()
            ], 500);
        }
    }
}
