<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class ServicioCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ticket_id  =   $this->request->get('ticket_id');
        $date_ticket=Ticket::find($ticket_id)->fecha_hora;
        //echo $date_ticket;
        //dd($date_ticket);
        //$this->ticket_id
        return [
            'fecha_programada' => 'required|date|after:'.$date_ticket,
            //'fecha_programada' => 'required',
            'ticket_id'=>'required',
            'descripcion'=>'required',
            'fecha_inicio'=>'date|after:fecha_programada|nullable',
            'fecha_fin'=>'date|after:fecha_programada|after:fecha_inicio|nullable',
            'descripcion'=>'required',
        ];
    }

    public function messages()
    {
        $ticket_id  =   $this->request->get('ticket_id');
        $date_ticket=Ticket::find($ticket_id)->fecha_hora;

        return[
            'fecha_programada.after'=>'La :attribute no puede ser menor a la fecha de creación del ticket :value '
        ];

        
        
        
    }
}
