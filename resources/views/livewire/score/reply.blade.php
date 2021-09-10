<div x-data="{ response: '' }">
    <form wire:submit.prevent="sendReply">
        <select x-model="response" wire:model.defer="seletedResponse" id="">
            <option value="" selected>Seleccione una respuesta</option>
            @foreach ($responses as $response)
            <option value="{{$response->response}}">{{$response->response}}</option>
            @endforeach
        </select>
        <textarea
            x-text="response"
            class="w-full border border-gray-100 rounded-sm resize-none bg-gray-25 focus:border-gray-100 focus:ring-gray-50"
            wire:model.defer="reply" rows="3">
        </textarea>
    </form>
</div>
