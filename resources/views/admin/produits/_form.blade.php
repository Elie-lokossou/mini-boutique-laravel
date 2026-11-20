{{-- Formulaire partagé entre la création et la modification.
     Chapitre 7 : si la validation échoue, Laravel revient ici avec
     les erreurs ($errors) et les anciennes valeurs (old()). --}}

<style>
    .form-carte { background:#fff; border-radius:10px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.08); max-width:640px; }
    .champ { margin-bottom:16px; }
    .champ label { display:block; font-weight:600; margin-bottom:6px; font-size:14px; }
    .champ input, .champ select, .champ textarea { width:100%; padding:10px; border:1px solid #c9d2e0; border-radius:6px; font-size:15px; }
    .champ input.invalide, .champ select.invalide, .champ textarea.invalide { border-color:#b3261e; }
    .erreur { color:#b3261e; font-size:13px; margin-top:4px; }
    .erreurs { background:#fdecea; color:#b3261e; border-radius:8px; padding:12px 16px; margin-bottom:16px; max-width:640px; }
    .btn { display:inline-block; background:#0866FF; color:#fff; border:none; padding:10px 18px; border-radius:6px; font-size:15px; font-weight:600; cursor:pointer; text-decoration:none; }
    .btn.secondaire { background:#e8edf5; color:#1f2430; }
</style>

@if ($errors->any())
    <div class="erreurs">
        <strong>Le formulaire contient des erreurs :</strong>
        <ul style="margin:6px 0 0; padding-left:18px;">
            @foreach ($errors->all() as $erreur)
                <li>{{ $erreur }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-carte">
    <div class="champ">
        <label for="nom">Nom du produit *</label>
        <input type="text" id="nom" name="nom"
               class="@error('nom') invalide @enderror"
               value="{{ old('nom', $produit->nom ?? '') }}">
        @error('nom') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3"
                  class="@error('description') invalide @enderror">{{ old('description', $produit->description ?? '') }}</textarea>
        @error('description') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ">
        <label for="prix">Prix (FCFA) *</label>
        <input type="number" id="prix" name="prix" step="0.01" min="0"
               class="@error('prix') invalide @enderror"
               value="{{ old('prix', $produit->prix ?? '') }}">
        @error('prix') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ">
        <label for="stock">Stock *</label>
        <input type="number" id="stock" name="stock" min="0"
               class="@error('stock') invalide @enderror"
               value="{{ old('stock', $produit->stock ?? 0) }}">
        @error('stock') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ">
        <label for="categorie_id">Catégorie *</label>
        <select id="categorie_id" name="categorie_id" class="@error('categorie_id') invalide @enderror">
            <option value="">— Choisir une catégorie —</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}"
                    @selected(old('categorie_id', $produit->categorie_id ?? '') == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn">{{ $bouton }}</button>
    <a class="btn secondaire" href="{{ route('admin.produits.index') }}">Annuler</a>
</div>
