# Live Validation System Documentation

## Overview

Sistem Live Validation ini memberikan umpan balik real-time kepada pengguna ketika mereka mengisi form, khususnya untuk mencegah duplikasi data. Sistem ini menggunakan Filament's live() method untuk memberikan peringatan dini sebelum user mencoba submit form.

## Components

### 1. HasDuplicateValidation Trait

**Location**: `app/Traits/HasDuplicateValidation.php`

Trait ini menyediakan metode untuk validasi duplikasi dan notifikasi yang konsisten:

```php
// Menampilkan notifikasi duplikasi dengan action buttons
showDuplicateNotification($existingRecord, $modelName, $editRoute, $viewRoute)

// Throw exception dengan pesan yang user-friendly
throwDuplicateValidationException($message)
```

### 2. HasLiveValidation Trait

**Location**: `app/Traits/HasLiveValidation.php`

Trait ini menyediakan helper untuk live validation:

```php
// Kirim warning notification
sendDuplicateWarning($message)

// Generate helper text dinamis
getDuplicateHelperText($defaultMessage, $hasData, $duplicateMessage, $safeMessage)

// Validasi live untuk field tahun_id (single constraint)
createTahunLiveValidation($modelClass)

// Validasi live untuk composite constraint (tahun + field lain)
createCompositeLiveValidation($modelClass, $fieldName, $getFieldFunction, $fieldLabel)

// Validasi tahun_id dalam composite constraint
createTahunCompositeLiveValidation($modelClass, $otherFieldName, $otherFieldGetter, $otherFieldLabel)
```

### 3. FormBuilder Helper

**Location**: `app/Helpers/FormBuilder.php`

Helper class untuk membuat form components dengan live validation:

```php
// Select tahun dengan live validation
FormBuilder::tahunSelect($modelClass, $isComposite, $otherField)

// Text input dengan live validation
FormBuilder::uniqueTextInput($fieldName, $label, $modelClass, $placeholder, $maxLength)

// Select dengan options dan live validation
FormBuilder::uniqueSelect($fieldName, $label, $options, $modelClass, $placeholder)
```

## Implementation Examples

### 1. Single Constraint Validation (UmurStatistik & DemografiPenduduk)

Untuk model dengan unique constraint pada `tahun_id` saja:

```php
Forms\Components\Select::make('tahun_id')
    ->label('Tahun Data')
    ->relationship('tahunData', 'tahun')
    ->required()
    ->searchable()
    ->preload()
    ->live()
    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
        if ($state) {
            $existing = UmurStatistik::where('tahun_id', $state)->exists();
            if ($existing) {
                \Filament\Notifications\Notification::make()
                    ->warning()
                    ->title('Perhatian!')
                    ->body('Tahun yang dipilih sudah memiliki data statistik umur.')
                    ->duration(3000)
                    ->send();
            }
        }
    })
    ->helperText(function ($state) {
        if (!$state) {
            return 'Pilih tahun untuk data statistik umur. Sistem akan mengecek ketersediaan data.';
        }

        $existing = UmurStatistik::where('tahun_id', $state)->exists();
        if ($existing) {
            return '⚠️ Data statistik umur untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
        }

        return '✅ Tahun ini belum memiliki data statistik umur. Aman untuk membuat data baru.';
    })
```

### 2. Composite Constraint Validation (DusunStatistik)

Untuk model dengan unique constraint pada `tahun_id` + `nama_dusun`:

```php
// Field tahun_id
Forms\Components\Select::make('tahun_id')
    ->label('Tahun Data')
    ->relationship('tahunData', 'tahun')
    ->required()
    ->searchable()
    ->preload()
    ->live()
    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
        $namaDusun = $get('nama_dusun');
        if ($state && $namaDusun) {
            $existing = DusunStatistik::where('tahun_id', $state)
                ->where('nama_dusun', $namaDusun)
                ->exists();
            if ($existing) {
                \Filament\Notifications\Notification::make()
                    ->warning()
                    ->title('Perhatian!')
                    ->body("Dusun '{$namaDusun}' untuk tahun yang dipilih sudah ada.")
                    ->duration(3000)
                    ->send();
            }
        }
    })
    ->helperText('Pilih tahun untuk data statistik dusun')

// Field nama_dusun
Forms\Components\TextInput::make('nama_dusun')
    ->label('Nama Dusun')
    ->required()
    ->maxLength(100)
    ->placeholder('Contoh: Dusun Mawar, Dusun Melati')
    ->live()
    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
        $tahunId = $get('tahun_id');
        if ($state && $tahunId) {
            $existing = DusunStatistik::where('tahun_id', $tahunId)
                ->where('nama_dusun', $state)
                ->exists();
            if ($existing) {
                \Filament\Notifications\Notification::make()
                    ->warning()
                    ->title('Perhatian!')
                    ->body("Dusun '{$state}' untuk tahun yang dipilih sudah ada.")
                    ->duration(3000)
                    ->send();
            }
        }
    })
    ->helperText(function ($state, Forms\Get $get) {
        if (!$state || !$get('tahun_id')) {
            return 'Masukkan nama dusun (maksimal 100 karakter). Sistem akan mengecek duplikasi.';
        }

        $existing = DusunStatistik::where('tahun_id', $get('tahun_id'))
            ->where('nama_dusun', $state)
            ->exists();
        if ($existing) {
            return "⚠️ Dusun '{$state}' untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.";
        }

        return "✅ Nama dusun '{$state}' untuk tahun ini belum ada. Aman untuk membuat data baru.";
    })
```

## User Experience Flow

### 1. Real-time Feedback

-   User mulai mengisi form
-   Ketika user memilih tahun atau mengisi field yang memiliki constraint, sistem langsung mengecek duplikasi
-   Jika ada duplikasi, sistem menampilkan warning notification
-   Helper text berubah secara dinamis memberikan informasi status

### 2. Visual Indicators

-   **Default**: "Pilih tahun untuk data. Sistem akan mengecek ketersediaan data."
-   **Warning**: "⚠️ Data untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi."
-   **Safe**: "✅ Tahun ini belum memiliki data. Aman untuk membuat data baru."

### 3. Submit Validation

-   Jika user tetap melanjutkan submit meskipun ada warning, sistem akan menampilkan notification dengan action buttons:
    -   "Edit Data yang Ada" - redirect ke edit page
    -   "Lihat Data" - redirect ke view page

## Performance Considerations

### 1. Efficient Queries

-   Live validation menggunakan `exists()` query yang efisien
-   Query hanya dijalankan ketika field yang relevan berubah
-   Tidak ada query berlebihan untuk data yang tidak perlu

### 2. Debouncing

-   Filament secara otomatis menerapkan debouncing untuk live validation
-   Mengurangi beban server dari terlalu banyak request

### 3. Caching Strategy

Untuk optimasi lebih lanjut, bisa ditambahkan:

```php
// Cache hasil validation untuk mengurangi database hits
$cacheKey = "duplicate_check_{$modelClass}_{$tahunId}_{$fieldValue}";
$existing = Cache::remember($cacheKey, 60, function() use ($modelClass, $tahunId, $fieldValue) {
    return $modelClass::where('tahun_id', $tahunId)
        ->where('field_name', $fieldValue)
        ->exists();
});
```

## Best Practices

### 1. Consistent Messaging

-   Gunakan format pesan yang konsisten across semua form
-   Sertakan informasi yang actionable
-   Gunakan bahasa yang user-friendly

### 2. Progressive Enhancement

-   Live validation adalah enhancement, bukan replacement untuk server-side validation
-   Selalu sertakan server-side validation sebagai fallback

### 3. Accessibility

-   Helper text memberikan context yang jelas
-   Color coding (⚠️, ✅) membantu user memahami status
-   Notification duration yang reasonable (3 detik)

### 4. Error Recovery

-   Berikan opsi untuk user ketika terjadi duplikasi
-   Redirect ke halaman edit atau view yang relevan
-   Maintain form state ketika memungkinkan

## Future Improvements

### 1. Advanced Validation

-   Fuzzy matching untuk nama dusun (typo detection)
-   Bulk validation untuk import data
-   Cross-table validation

### 2. Enhanced UX

-   Modal confirmation sebelum override data
-   Auto-fill dari data existing
-   Preview existing data dalam tooltip

### 3. Reporting

-   Track validation patterns
-   Identify frequent duplication attempts
-   Generate reports untuk data quality

## Usage Guidelines

### 1. When to Use Live Validation

-   ✅ Form dengan unique constraints
-   ✅ Data yang frequently duplicated
-   ✅ High-value data yang butuh confirmation
-   ❌ Simple forms tanpa constraint
-   ❌ Performance-critical forms dengan large datasets

### 2. Implementation Checklist

-   [ ] Identify unique constraints dalam model
-   [ ] Implement live validation pada relevant fields
-   [ ] Test dengan various scenarios
-   [ ] Verify performance dengan realistic data volume
-   [ ] Document validation rules untuk future developers

### 3. Testing Strategy

-   Unit tests untuk validation logic
-   Integration tests untuk form behavior
-   User acceptance tests untuk UX flow
-   Performance tests untuk load scenarios
