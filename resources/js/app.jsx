import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';

const initialForm = {
    checkin: '',
    checkout: '',
    paxes: '2',
    hotel: '',
};

function getErrorMessage(error, fallback) {
    return error instanceof Error && error.message ? error.message : fallback;
}

function AvailabilityApp() {
    const [form, setForm] = useState(initialForm);
    const [hotels, setHotels] = useState([]);
    const [results, setResults] = useState([]);
    const [hotelError, setHotelError] = useState('');
    const [availabilityError, setAvailabilityError] = useState('');
    const [isLoadingHotels, setIsLoadingHotels] = useState(true);
    const [isSearching, setIsSearching] = useState(false);

    useEffect(() => {
        async function loadHotels() {
            try {
                const response = await fetch('/api/v1/hotels');
                if (!response.ok) throw new Error('Unable to load hotels.');
                setHotels(await response.json());
            } catch (error) {
                setHotelError(getErrorMessage(error, 'Unable to load hotels.'));
            } finally {
                setIsLoadingHotels(false);
            }
        }

        loadHotels();
    }, []);

    function updateField(event) {
        setForm({ ...form, [event.target.name]: event.target.value });
    }

    async function searchAvailability(event) {
        event.preventDefault();
        setAvailabilityError('');
        setResults([]);
        setIsSearching(true);

        const payload = {
            paxes: Number(form.paxes),
            checkin: form.checkin,
            checkout: form.checkout,
        };

        if (form.hotel) payload.hotel = form.hotel;

        try {
            const response = await fetch('/api/v1/availability', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
                body: JSON.stringify(payload),
            });

            if (!response.ok) {
                const errorBody = await response.json().catch(() => null);
                const message = errorBody?.message || 'Unable to check availability.';
                throw new Error(message);
            }

            setResults(await response.json());
        } catch (error) {
            setAvailabilityError(getErrorMessage(error, 'Unable to check availability.'));
        } finally {
            setIsSearching(false);
        }
    }

    return (
        <main className="min-h-screen bg-stone-50 px-4 py-8 text-slate-900 sm:px-6 lg:px-8">
            <div className="mx-auto max-w-5xl">
                <header className="mb-8 max-w-2xl">
                    <p className="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-teal-700">YABE / Disponibilidad</p>
                    <h1 className="text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Encuentra tu habitación</h1>
                    <p className="mt-4 text-lg leading-8 text-slate-600">Consulta las opciones disponibles en nuestros hoteles para tus próximas fechas.</p>
                </header>

                <section className="rounded-3xl bg-white p-5 shadow-xl shadow-slate-200/60 ring-1 ring-slate-200 sm:p-8">
                    <form onSubmit={searchAvailability} className="grid gap-5 md:grid-cols-2 lg:grid-cols-4 lg:items-end">
                        <label className="text-sm font-medium text-slate-700">
                            Entrada
                            <input required type="date" name="checkin" value={form.checkin} onChange={updateField} className="mt-2 block w-full rounded-xl border-slate-300 px-3 py-3 text-slate-900 shadow-sm focus:border-teal-600 focus:ring-teal-600" />
                        </label>
                        <label className="text-sm font-medium text-slate-700">
                            Salida
                            <input required type="date" name="checkout" value={form.checkout} onChange={updateField} className="mt-2 block w-full rounded-xl border-slate-300 px-3 py-3 text-slate-900 shadow-sm focus:border-teal-600 focus:ring-teal-600" />
                        </label>
                        <label className="text-sm font-medium text-slate-700">
                            Huéspedes
                            <input required min="1" type="number" name="paxes" value={form.paxes} onChange={updateField} className="mt-2 block w-full rounded-xl border-slate-300 px-3 py-3 text-slate-900 shadow-sm focus:border-teal-600 focus:ring-teal-600" />
                        </label>
                        <label className="text-sm font-medium text-slate-700">
                            Hotel <span className="font-normal text-slate-400">(opcional)</span>
                            <select name="hotel" value={form.hotel} onChange={updateField} disabled={isLoadingHotels} className="mt-2 block w-full rounded-xl border-slate-300 px-3 py-3 text-slate-900 shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                <option value="">Todos los hoteles</option>
                                {hotels.map((hotel) => <option key={hotel.code} value={hotel.code}>{hotel.name}</option>)}
                            </select>
                        </label>
                        <button disabled={isSearching} type="submit" className="rounded-xl bg-teal-700 px-5 py-3 font-semibold text-white transition hover:bg-teal-800 disabled:cursor-not-allowed disabled:opacity-60 md:col-span-2 lg:col-span-4">
                            {isSearching ? 'Buscando disponibilidad...' : 'Consultar disponibilidad'}
                        </button>
                    </form>

                    {hotelError && <p role="alert" className="mt-4 rounded-xl bg-amber-50 px-4 py-3 text-sm text-amber-800">{hotelError}</p>}
                    {availabilityError && <p role="alert" className="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{availabilityError}</p>}
                </section>

                <section className="mt-10" aria-live="polite">
                    <div className="mb-4 flex items-end justify-between gap-4">
                        <div>
                            <p className="text-sm font-semibold uppercase tracking-[0.15em] text-slate-400">Resultados</p>
                            <h2 className="mt-1 text-2xl font-semibold text-slate-950">Habitaciones disponibles</h2>
                        </div>
                        {results.length > 0 && <span className="rounded-full bg-teal-100 px-3 py-1 text-sm font-semibold text-teal-800">{results.length} opciones</span>}
                    </div>
                    {results.length === 0 && !isSearching && <div className="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-slate-500">Completa las fechas para ver las habitaciones disponibles.</div>}
                    <div className="grid gap-4 sm:grid-cols-2">
                        {results.map((result, index) => (
                            <article key={`${result.hotel.code}-${result.roomType.code}-${index}`} className="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                <div className="flex items-start justify-between gap-4">
                                    <div>
                                        <p className="text-sm text-slate-500">{result.hotel.name}</p>
                                        <h3 className="mt-1 text-xl font-semibold text-slate-950">{result.roomType.name}</h3>
                                    </div>
                                    <p className="whitespace-nowrap text-xl font-semibold text-teal-700">{Number(result.price).toFixed(2)} €</p>
                                </div>
                                <p className="mt-5 text-sm text-slate-500">Hasta {result.roomType.maxOccupancy} huéspedes</p>
                            </article>
                        ))}
                    </div>
                </section>
            </div>
        </main>
    );
}

const rootElement = document.getElementById('app');
if (rootElement) createRoot(rootElement).render(<AvailabilityApp />);
