<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Component;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    public function index(Request $request)
    {
        $this->check_permission();
        /*$types = Type::orderBy('id', 'desc')
            ->paginate(15);*/

        $typeQuery = Type::query();
        if ($request->filled('search_field')){
            $typeQuery->where('name', 'LIKE', '%'.$request->search_field.'%');
        }
        if ($request->filled('selected_manufacturer')){
            $typeQuery->where('manufacturer', $request->selected_manufacturer);
        }
        //$types = $typeQuery->withPath("?" . $request->getQueryString());
        $types = $typeQuery->get();
        $types_manufacturers = Type::groupBy('manufacturer')->get();
        return view('admin.types.index', compact(['types', 'types_manufacturers']));
    }



    public function create()
    {
        $this->check_permission();
        return view('admin.types.create');
    }



    public function store(Request $request)
    {
        $this->check_permission();

        $type = Type::create($request->all());

        // загружаем изображения на сервер
        if($request->has('image_uzt'))
            $this->uploadImage($request->image_uzt, $type->id, 'uzt');
        if($request->has('image_mk'))
            $this->uploadImage($request->image_mk, $type->id, 'mk');
        if($request->has('image_vik'))
            $this->uploadImage($request->image_vik, $type->id, 'vik');
        if($request->has('image_uk'))
            $this->uploadImage($request->image_uk, $type->id, 'uk');
        if($request->has('image_diagram_crimping'))
            $this->uploadDiagram($request->image_diagram_crimping, $type->id, 'diagram_crimping');
        return redirect()
            ->to(route('types.index'))
            ->with('success', 'Оборудование успешно добавлено');
    }

    /*
     * загрузка файлов изображений на сервер
     */
    public function uploadImage($image, $type_id, $type_image):void
    {

        // путь к документу
        $document_path = public_path('/types_data/'.$type_id.'/');
        // если не создана директория - создаём её
        @mkdir($document_path);
        // если остался старый файл - удаляем его
        if(file_exists($document_path.$type_image.'.jpg'))
        {
            @unlink($document_path.$type_image.'.jpg');
        }

        $image->move($document_path, $type_image.'.jpg');

    }
    
    /*
     * сжатие, загрузка изображения диаграммы
     */
    public function uploadDiagram($image, $type_id, $type_image):void
    {

        // путь к документу
        $document_path = public_path('/types_data/'.$type_id.'/');
        // если не создана директория - создаём её
        @mkdir($document_path);
        // если остался старый файл - удаляем его
        if(file_exists($document_path.$type_image.'.jpg'))
        {
            @unlink($document_path.$type_image.'.jpg');
        }

        $img = Image::make($image->getRealPath());
        $img->resize(600, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->save($document_path.$type_image.'.jpg');
    }


    public function edit($id)
    {
        $this->check_permission();
        $type = Type::findOrFail($id);

        return view('admin.types.edit', [
            'type' => $type,
        ]);
    }



    public function update(Request $request, $id)
    {
        $this->check_permission();
        if(isset($request->is_non_typical_type) && $request->is_non_typical_type == '1')
            $request->merge(['is_non_typical_type' => 1]);
        else
            $request->merge(['is_non_typical_type' => 0]);

        $type = Type::findOrFail($id);
        $type->update($request->all());
        // если были выбраны изображения - загружаем их
        if($request->has('image_uzt'))
            $this->uploadImage($request->image_uzt, $type->id, 'uzt');
        if($request->has('image_mk'))
            $this->uploadImage($request->image_mk, $type->id, 'mk');
        if($request->has('image_vik'))
            $this->uploadImage($request->image_vik, $type->id, 'vik');
        if($request->has('image_uk'))
            $this->uploadImage($request->image_uk, $type->id, 'uk');
        if($request->has('image_diagram_crimping'))
            $this->uploadDiagram($request->image_diagram_crimping, $type->id, 'diagram_crimping');

        return redirect()
            ->to(route('types.index'))
            ->with('success', 'Информация успешно изменена');
    }



    public function destroy($id)
    {
        $this->check_permission();
        $type = Type::findOrFail($id);
        $type->delete();

        return redirect()
            ->to(route('types.index'))
            ->with('success', 'Оборудование успешно удалёно');
    }
    
    // Удланеие картинки типа
    public function deleteImgType(Request $request) 
    {
        $typeId = $request->type_id;
        $document_path = public_path('/types_data/'.$typeId.'/');
        $typeImg = $request->type_img;
        $responseData = [];
        // если есть файл - удаляем его
        if(file_exists($document_path.$typeImg.'.jpg'))
        {
            @unlink($document_path.$typeImg.'.jpg');
            $responseData = [
                    'result' => true,
                    'msg' => 'Файл удален успешно.'
                ];
        } else {
            $responseData = [
                    'result' => false,
                    'msg' => 'Не найден файл для удаления!'
                ];
        }
        
        return $responseData;
    }
}
