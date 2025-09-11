# Content Manager Package

A comprehensive content management package for the NetAuraTech CoreCMS system, providing a complete solution for managing pages, articles, templates, categories, and tags.

## Description

This package extends the CoreCMS functionality by providing a robust content management system with visual block-based editing, form handling, SEO optimization, and multi-content type support. It integrates seamlessly with the CoreCMS architecture to deliver a powerful content creation and management experience.

## Features

- ✅ **Multi-Content Type Support**: Pages, articles, templates, and more
- ✅ **Visual Block Editor**: Drag-and-drop interface with live preview
- ✅ **Category and Tag Management**: Organize content with taxonomies
- ✅ **SEO Optimization**: Automatic sitemap generation and robots.txt
- ✅ **Form Builder**: Contact forms and custom form generation
- ✅ **Template System**: Reusable content blocks via shortcodes
- ✅ **Cache Management**: Intelligent cache purging and preloading
- ✅ **Multilingual Support**: Built-in translation system
- ✅ **Responsive Admin Interface**: Modern, user-friendly administration
- ✅ **CAPTCHA Integration**: Spam protection for forms
- ✅ **Asset Management**: Automatic CSS generation and optimization
- ✅ **Content Scheduling**: Publish/unpublish content with dates

## Requirements

- PHP ^8.1
- Laravel ^12.0
- NetAuraTech CoreCMS ^1.0

## Dependencies

### Frontend Dependencies
- Preact ^10.27.0 (React-like library for UI components)
- Quill ^2.0.3 (Rich text editor)
- TomSelect ^2.4.3 (Advanced select component)
- SortableJS ^1.15.6 (Drag & drop functionality)
- Zustand ^5.0.3 (State management)
- Tippy.js ^6.3.7 (Tooltips)
- DOMPurify ^3.2.6 (HTML sanitization)

## Installation

### Via Composer (Recommended)

```bash
composer require netauratech/content-manager
```

### Manual Installation

1. Clone the repository into your Laravel project
2. Add the dependency to your `composer.json`
3. Run `composer install`

## Configuration

### 1. Service Provider Registration

The service provider is automatically registered through Laravel's package discovery. For manual registration, add to `config/app.php`:

```php
'providers' => [
    // ...
    Netauratech\ContentManager\ContentManagerServiceProvider::class,
],
```

### 2. Database Migration

Publish and run the migrations:

```bash
php artisan vendor:publish --tag=core-cms-migrations
php artisan migrate
```

### 3. Database Seeding (Optional)

Publish and run the seeders:

```bash
php artisan vendor:publish --tag=core-cms-seeders
php artisan db:seed --class=ContentSeeder
```

### 4. Translation Files

Publish translation files to customize messages:

```bash
php artisan vendor:publish --tag=core-cms-translations
```

## Usage

### Content Management

#### Creating Content

Navigate to the admin panel and access content management:
- **Pages**: `/admin/contents/page`
- **Articles**: `/admin/contents/article`
- **Templates**: `/admin/contents/template`

#### Content Types

**Pages**
- Static content with flexible layouts
- Can be set as homepage
- SEO-optimized with meta fields

**Articles**
- Blog-style content with categories and tags
- Publication scheduling
- Archive and draft support

**Templates**
- Reusable content blocks
- Can be embedded via shortcodes: `[template id=123]`
- Shared across multiple pages

### Visual Editor

The package includes a powerful visual editor with drag-and-drop functionality and live preview. The editor uses a block-based system where each block is defined as a JSON object:

```json
{
    "_name": "section",
    "title": "Welcome Section",
    "content": "<p>Your content here</p>",
    "background-color": "#f8f9fa",
    "padding-block": "large"
}
```

#### Available Blocks

- **Section**: Basic content block with title, text, and media
- **Carousel**: Sliding content blocks
- **Gallery**: Automatic image gallery with lightbox
- **Contact Form**: Built-in contact functionality
- **Custom Forms**: Dynamic form builder
- **Media**: Image/video display with advanced options
- **Links**: Navigation and link lists
- **Theme Switcher**: Dark/light mode toggle

#### Creating Custom Blocks

You can extend the visual editor by adding custom blocks through your theme's JavaScript. The editor provides a comprehensive API for creating custom components with sophisticated field types and layouts.

**Setting up Theme Extensions**

Create a JavaScript file in your theme and define new components using the editor's API:

```javascript
const translate = window.translate;
const editor = window.editor;
const layouts = editor.layouts;
const fields = editor.fields;

editor.initializeTheme = function(options) {
    // Set internal page/content options for links
    editor.setOptions(options);
    
    const components = [
        {
            _id: 'hero-section',
            label: translate('theme.blocks.hero.label'),
            title: translate('theme.blocks.hero.title'), 
            category: translate('content-manager.admin.editor.category.content'),
            canEditAppearance: true, // Enables background, animation, appearance tabs
            fields: [
                // Title with styling options
                editor.titleField('title', translate('content-manager.admin.editor.sidebar.tabs.title.value')),
                
                // Rich text content with color palette
                fields.HtmlText('content', {
                    label: translate('content-manager.admin.editor.sidebar.tabs.content'),
                    colors: Object.values(editor.colors()),
                    canAnimate: true
                }),
                
                // Media field with advanced options
                ...editor.mediaField('hero-image'),
                
                // Call-to-action buttons
                fields.Repeater('buttons', {
                    addLabel: translate('core-cms.admin.add'),
                    fields: [...editor.links()], // Reuse link helper
                    label: translate('content-manager.admin.editor.sidebar.tabs.ctas')
                })
            ]
        },
        {
            _id: 'testimonials',
            title: translate('theme.blocks.testimonials.title'),
            category: translate('content-manager.admin.editor.category.content'),
            fields: [
                layouts.Row([
                    fields.Text('title', {
                        label: translate('content-manager.admin.editor.sidebar.tabs.title.value'),
                        canAnimate: true
                    }),
                    fields.Number('columns', {
                        label: translate('theme.fields.columns'),
                        default: "3",
                        min: 1,
                        max: 4
                    })
                ]),
                
                fields.Repeater('testimonials', {
                    addLabel: translate('theme.add_testimonial'),
                    collapsed: 'author', // Use author field as collapse title
                    fields: [
                        fields.Text('quote', {
                            label: translate('theme.fields.quote'),
                            multiline: true
                        }),
                        fields.Text('author', {
                            label: translate('theme.fields.author')
                        }),
                        fields.Text('position', {
                            label: translate('theme.fields.position')
                        }),
                        fields.Media('avatar', {
                            label: translate('theme.fields.avatar')
                        })
                    ],
                    label: translate('theme.fields.testimonials')
                })
            ]
        }
    ];

    // Register all custom components
    editor.registerComponents(components);
    editor.defineElement();
};
```

#### Field Types Available

The editor provides a comprehensive set of field types:

**Basic Fields:**
- `fields.Text(name, options)` - Single line text input
- `fields.HtmlText(name, options)` - Rich text editor with Quill
- `fields.Number(name, options)` - Numeric input with min/max/step
- `fields.Range(name, options)` - Slider input
- `fields.Checkbox(name, options)` - Boolean switch
- `fields.Select(name, options)` - Dropdown selection
- `fields.Color(name, options)` - Color picker with palette
- `fields.Media(name, options)` - File/image picker
- `fields.DatePicker(name, options)` - Date selection

**Advanced Fields:**
- `fields.Repeater(name, options)` - Dynamic array of fields
- `layouts.Row(fields)` - Horizontal field layout
- `layouts.Tabs(tabDefinitions)` - Tabbed field organization

**Helper Methods:**
- `editor.titleField(name, label)` - Complete title with styling options
- `editor.mediaField(name)` - Media with alt text and sizing
- `editor.animationField(key, label)` - Animation controls
- `editor.links()` - Internal/external link fields
- `editor.baseTabs(fields)` - Standard content/animation/background/appearance tabs

#### Field Options

Each field type supports various options:

```javascript
fields.Text('field-name', {
    label: 'Field Label',
    help: 'Help text shown below field',
    default: 'Default value',
    multiline: false, // Use textarea if true
    canAnimate: true // Adds animation controls in appearance tab
})

fields.Select('choice', {
    label: 'Make a Choice',
    options: [
        { value: 'option1', label: 'Option 1' },
        { value: 'option2', label: 'Option 2' }
    ],
    default: 'option1'
})

fields.Repeater('items', {
    label: 'Item List',
    addLabel: 'Add New Item',
    collapsed: 'title', // Field name to use as collapse title
    min: 1, // Minimum items
    max: 10, // Maximum items
    fields: [
        // Nested field definitions
    ]
})
```

#### Conditional Fields

Fields can be shown/hidden based on other field values:

```javascript
fields.Text('subtitle', {
    label: 'Subtitle'
}).when('show-subtitle', true), // Only show when show-subtitle is true

fields.Color('text-color', {
    label: 'Text Color'
}).when('style-type', 'custom'), // Only show when style-type equals 'custom'
```

#### Block Categories

Organize custom blocks using predefined categories:

- `translate('content-manager.admin.editor.category.content')` - Content blocks
- `translate('content-manager.admin.editor.category.layout')` - Layout containers
- `translate('content-manager.admin.editor.category.template')` - Template components

#### Creating Block Templates

After defining JavaScript components, create corresponding Blade templates in your theme:

```php
// resources/views/theme/hero-section.blade.php
@extends('content-manager::shared.blocks.layouts.layout')

@php
    $block = $block ?? [];
    $section = $section ?? 'section';
    $classes = ['hero-section'];
@endphp

@section('class')
    {{ join(' ', $classes) }}
@overwrite

@section('element')
    {{ $section }}
@overwrite

@section('content')
    <div class="container">
        @if(!empty($block['hero-image']))
            <div class="hero-image">
                {!! image_tag($block['hero-image'], $block['hero-image-alt'] ?? '', $block['hero-image-width'] ?? null) !!}
            </div>
        @endif
        
        @if(!empty($block['title']))
            @include('content-manager::shared.blocks.components.title', ['block' => $block])
        @endif
        
        @if(!empty($block['content']))
            @include('content-manager::shared.blocks.components.content', ['block' => $block])
        @endif
        
        @if(!empty($block['buttons']))
            <div class="hero-buttons">
                @foreach($block['buttons'] as $button)
                    @include('content-manager::shared.blocks.components.cta', ['block' => $button])
                @endforeach
            </div>
        @endif
    </div>
@overwrite
```

#### Advanced Features

**CSS Integration**
The package automatically generates CSS for each block based on its settings. Custom properties are available for styling:

```css
.block__[hash] {
    --background-color: /* User selected color */;
    --grid-gap: /* User selected gap */;
}

.block__[hash]-title {
    color: /* User selected title color */;
    text-decoration: /* User selected decoration */;
}
```

This comprehensive system allows themes to create sophisticated, user-friendly content blocks while maintaining consistency with the CMS architecture.

### Categories and Tags

Organize content with hierarchical systems:

```php
// Create categories
$category = new Category();
$category->name = 'Technology';
$category->save();

// Attach to content
$content->categories()->attach($category->id);
```

### Form Handling

#### Contact Forms

Built-in contact form with CAPTCHA protection:

```php
Route::post('/forms/{slug}/contact', [FormSubmissionController::class, 'submit']);
```

#### Custom Forms

Create dynamic forms through the visual editor:

```php
// Form sections with various field types
'sections' => [
    [
        'title' => 'Personal Information',
        'visible' => true,
        'fields' => [
            [
                'label' => 'Full Name',
                'type' => 'text',
                'help' => 'Enter your full name'
            ],
            [
                'label' => 'Country',
                'type' => 'select',
                'options' => [
                    ['option' => 'France'],
                    ['option' => 'Germany']
                ]
            ]
        ]
    ]
]
```

### SEO Features

#### Automatic Sitemap

The package generates XML sitemaps automatically:

```xml
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://example.com/</loc>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
</urlset>
```

#### Robots.txt

Dynamic robots.txt with sitemap reference:

```
User-agent: *
Disallow: /admin/
Disallow: /profile/

Sitemap: https://example.com/sitemap.xml
```

### Template System

Use templates across content via shortcodes:

```php
// In content
"Welcome to our site! [template id=3] Thank you for visiting."

// Renders the template content inline
```

### Caching & Performance

The package includes intelligent caching:

```php
// Automatic cache purging on content updates
public function purge(Content $content): void
{
    // Clear related URLs
    // Precache updated content
    // Notify CDN if configured
}
```

### API Integration

Extend functionality through content providers:

```php
class CustomContentProvider implements ContentProviderInterface
{
    public function getArticles(int $perPage = 10): LengthAwarePaginator
    {
        return Content::where('type', 'article')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }
}
```

## Customization

### Block Templates

Create custom block templates:

```php
// resources/views/theme/custom-block.blade.php
@extends('content-manager::shared.blocks.layouts.layout')

@section('content')
    <div class="custom-block">
        {{ $block['custom-field'] }}
    </div>
@endsection
```

### Admin Menu Integration

The package automatically registers menu items:

```php
$menuManager->registerMenuItem('content-management', [
    'label' => 'Content',
    'children' => [
        [
            'label' => 'Pages',
            'route' => 'admin.contents.index',
            'params' => ['type' => 'page']
        ]
    ]
]);
```

### CSS Generation

Automatic CSS generation for visual blocks:

```css
.block__a1b2c3d4 {
    --background-color: #f8f9fa;
    --grid-gap: 2rem;
}

.block__a1b2c3d4-title {
    color: #333;
    text-decoration-line: underline;
}
```

## File Structure

```
src/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── CategoryController.php
│   │   │   ├── ContentController.php
│   │   │   └── TagController.php
│   │   ├── FormSubmissionController.php
│   │   ├── PageController.php
│   │   └── SeoContentController.php
│   └── Requests/
│       └── Admin/
├── Models/
│   ├── Category.php
│   ├── Content.php
│   └── Tag.php
├── Services/
│   ├── ContentProvider.php
│   ├── ContentPurgeProvider.php
│   └── Shortcode/
├── Mail/
├── Jobs/
├── Observers/
├── resources/
│   ├── ts/ (TypeScript components)
│   └── views/ (Blade templates)
├── routes/
├── database/
└── lang/
```

## Security Features

- CSRF protection on all forms
- CAPTCHA integration for spam prevention
- Input validation and sanitization
- XSS protection through DOMPurify
- Permission-based access control

## Performance Optimization

- Lazy CSS loading with preload hints
- Database query optimization
- Intelligent cache management
- Asset concatenation and minification
- Image optimization helpers

## Translation Support

The package supports multiple languages:

```php
// lang/en/admin.php
return [
    'content' => [
        'title' => 'Title',
        'status' => [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived'
        ]
    ]
];
```

Available translation keys:
- Content management interface
- Form labels and validation messages
- Status indicators
- Navigation elements

## Development

### Contributing

1. Fork the project
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Testing

```bash
# Run tests
php artisan test

# Frontend testing
npm test
```

## API Reference

### ContentProviderInterface

```php
interface ContentProviderInterface
{
    public function getArticles(int $perPage = 10): LengthAwarePaginator;
    public function getPages(int $perPage = 10): LengthAwarePaginator;
    public function getContentById(int $id): ?object;
    public function getContentBySlug(string $slug): ?object;
}
```

### Events

```php
// Dispatched when content is saved
ContentSaved::dispatch($content, $request);

// Listen for language loading
LangLoaded::dispatch('content-manager');
```

## Troubleshooting

### Common Issues

**Assets Not Loading**
```bash
# Clear cache and rebuild
php artisan cache:clear
php artisan view:clear
```

**Migration Issues**
```bash
# Check migration status
php artisan migrate:status

# Rollback if needed
php artisan migrate:rollback --step=1
```

## License

This package is open-source software licensed under the [MIT license](LICENSE).

## Support

For support or questions:
- **Email**: contact@netauratech.fr
- **Documentation**: Check the CoreCMS documentation
- **Issues**: Create an issue on GitHub

## Changelog

### v1.0.0
- Initial release
- Multi-content type support
- Visual block editor
- SEO optimization
- Form handling system
- Cache management
- Translation support

## Authors

**NetAuraTech** - *Initial work* - [NetAuraTech](mailto:contact@netauratech.fr)

---

© 2025 NetAuraTech. All rights reserved.