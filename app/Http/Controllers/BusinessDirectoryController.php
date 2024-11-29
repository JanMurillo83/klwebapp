<?php

namespace App\Http\Controllers;
use App\Models\BusinessDirectory;
use App\Models\FactoryCompany;
use Illuminate\Http\Request;

class BusinessDirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = BusinessDirectory::all();
        return view('business_directory.index', compact('entries'));
    }
    public function createCustomer()
    {
        $factoryCompanies = FactoryCompany::all();
        return view('business_directory.customer.create', compact('factoryCompanies'));
    }

    public function storeCustomer(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'type' => 'required|in:station,customer,supplier',
            'company' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'billing_currency' => 'required|in:USD,MXN',
            'rfc_tax_id' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'building_number' => 'nullable|string|max:20',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'credit_days' => 'nullable|integer',
            'credit_expiration_date' => 'nullable|date',
            'free_loading_unloading_hours' => 'nullable|integer',
            'factory_company_id' => 'nullable|exists:factory_companies,id',
            'notes' => 'nullable|string',
            'document_expiration_date' => 'nullable|date',
            'picture' => 'nullable|image|max:2048', // Valida imágenes
            'add_document' => 'nullable|file|max:2048', // Valida documentos
            'tarifario' => 'nullable|string', // Valida tarifario
        ]);
        logger('Validated data:', $validated);

        // Manejo de archivo de imagen
        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('pictures', 'public'); // Guarda en storage/public/pictures
            logger('Picture stored at:', ['path' => $picturePath]);
        }
        // Manejo de archivo de documento
        $documentPath = null;
        if ($request->hasFile('add_document')) {
            $documentPath = $request->file('add_document')->store('documents', 'public'); // Guarda en storage/public/documents
            logger('Document stored at:', ['path' => $documentPath]);
        }


        // Crear nueva entrada
        BusinessDirectory::create(array_merge($validated, ['picture' => $picturePath, 'add_document' => $documentPath]));

        // Redirigir con éxito
        return redirect()->route('business-directory.index')->with('success', 'Customer created successfully.');
    }
}
