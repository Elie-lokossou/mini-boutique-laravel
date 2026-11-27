{{-- Formulaire partagé pour créer ou modifier un produit. --}}
@if ($errors->any())
    <div class="form-errors">
        <strong>Vérifie les champs suivants :</strong>
        <ul style="margin:6px 0 0;padding-left:18px">
            @foreach ($errors->all() as $erreur)
                <li>{{ $erreur }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">
    <div class="field">
        <label for="nom">Nom du produit *</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom', $produit->nom ?? '') }}" required>
        @error('nom') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="description">Description</label>
        <textarea id="description" name="description">{{ old('description', $produit->description ?? '') }}</textarea>
        @error('description') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="prix">Prix en FCFA *</label>
        <input type="number" id="prix" name="prix" step="0.01" min="0" value="{{ old('prix', $produit->prix ?? '') }}" required>
        @error('prix') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="stock">Quantité en stock *</label>
        <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $produit->stock ?? 0) }}" required>
        @error('stock') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="categorie_id">Catégorie *</label>
        <select id="categorie_id" name="categorie_id" required>
            <option value="">Choisir une catégorie</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $produit->categorie_id ?? '') == $categorie->id)>{{ $categorie->nom }}</option>
            @endforeach
        </select>
        @error('categorie_id') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="image">Photo du produit (JPG, PNG ou WebP, 3 Mo maximum)</label>
        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
        @if (isset($produit) && $produit->image)
            <p style="margin:8px 0 0;color:var(--muted);font-size:11px">Une photo est déjà enregistrée. Ajouter un fichier la remplacera.</p>
        @endif
        @error('image') <p class="field-error">{{ $message }}</p> @enderror
    </div>

    <div class="form-actions">
        <button class="button" type="submit">{{ $bouton }}</button>
        <a class="button secondary" href="{{ route('admin.produits.index') }}">Annuler</a>
    </div>
</div>
