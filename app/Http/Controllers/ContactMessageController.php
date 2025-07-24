<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactMessageController extends Controller
{
    /**
     * Mostrar todos los mensajes de contacto
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Filtrar por estado si se proporciona
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Buscar por nombre o email
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('contact-messages.index', compact('messages'));
    }

    /**
     * Mostrar un mensaje específico
     */
    public function show(ContactMessage $contactMessage)
    {
        // Marcar como leído si está pendiente
        if ($contactMessage->status === 'pending') {
            $contactMessage->markAsRead();
        }

        return view('contact-messages.show', compact('contactMessage'));
    }

    /**
     * Procesar el formulario de contacto
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'phone' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'phone' => $request->phone,
                'status' => 'pending'
            ]);

            // Enviar notificación por email (opcional)
            // $this->sendNotificationEmail($contactMessage);

            return response()->json([
                'success' => true,
                'message' => session('language') === 'en' 
                    ? 'Your message has been sent successfully!' 
                    : '¡Tu mensaje ha sido enviado exitosamente!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => session('language') === 'en' 
                    ? 'There was an error sending your message. Please try again.' 
                    : 'Hubo un error al enviar tu mensaje. Por favor intenta de nuevo.'
            ], 500);
        }
    }

    /**
     * Mostrar formulario para responder
     */
    public function reply(ContactMessage $contactMessage)
    {
        return view('contact-messages.reply', compact('contactMessage'));
    }

    /**
     * Enviar respuesta por email
     */
    public function sendReply(Request $request, ContactMessage $contactMessage)
    {
        $validator = Validator::make($request->all(), [
            'reply_message' => 'required|string|min:10',
            'subject' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Enviar email
            Mail::send('emails.contact-reply', [
                'contactMessage' => $contactMessage,
                'replyMessage' => $request->reply_message,
                'replySubject' => $request->subject
            ], function ($message) use ($contactMessage, $request) {
                $message->to($contactMessage->email, $contactMessage->name)
                        ->subject($request->subject)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            // Marcar como respondido
            $contactMessage->markAsReplied(
                $request->reply_message,
                auth()->user()->name ?? 'Sistema'
            );

            return redirect()->route('contact-messages.index')
                ->with('success', '¡Respuesta enviada exitosamente!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al enviar la respuesta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Cambiar estado del mensaje
     */
    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,read,replied,archived'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contactMessage->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }

    /**
     * Eliminar mensaje
     */
    public function destroy(ContactMessage $contactMessage)
    {
        try {
            $contactMessage->delete();
            
            return redirect()->route('contact-messages.index')
                ->with('success', 'Mensaje eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el mensaje');
        }
    }

    /**
     * Obtener estadísticas de mensajes
     */
    public function stats()
    {
        $stats = [
            'total' => ContactMessage::count(),
            'pending' => ContactMessage::pending()->count(),
            'read' => ContactMessage::read()->count(),
            'replied' => ContactMessage::replied()->count(),
            'today' => ContactMessage::whereDate('created_at', today())->count(),
            'this_week' => ContactMessage::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count()
        ];

        return response()->json($stats);
    }
}