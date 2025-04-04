<x-app-layout>

            <h1>Bedrijven Zonder Factuur</h1>
            <table>
                <thead>
                <tr>
                    <th>Bedrijf Naam</th>
                    <th>Acties</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bedrijven as $bedrijf)
                    <tr>
                        <td>{{ $bedrijf->naam }}</td>
                        <td><a href="{{ route('bedrijfs.show', $bedrijf) }}">Bekijk Detail</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

</x-app-layout>
