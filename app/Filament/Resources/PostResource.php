<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;

class PostResource extends Resource {
	protected static ?string $model = Post::class;

	protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

	public static function form( Form $form ): Form {
		return $form
			->schema( [
				Section::make( 'Main Content' )
					->schema( [
						TextInput::make( 'title' )
							->afterStateUpdated( function (Get $get, Set $set, string $operation) {
								if ( $operation != 'edit' ) {
									$set( 'slug', Str::slug( $get( 'title' ), '-' ) );
								}
							} )
							->minLength( 1 )
							->maxLength( 150 )
							->required()
							->live( onBlur: true )->columns( 1 ),
						TextInput::make( 'slug' )
							->minLength( 1 )
							->maxLength( 150 )
							->required()
							->unique( ignoreRecord: true )->columns( 1 ),
						RichEditor::make( 'body' )
							->fileAttachmentsDirectory( 'posts/images' )
							->minLength( 1 )
							->maxLength( 300 )
							->required()->columnSpan( 2 ),

					] )->columns( 2 ),
				Section::make( 'Meta' )
					->schema( [
						FileUpload::make( 'image' )
							->image()
							->directory( 'posts/thumbnails' )
							->columnSpan( 2 ),
						DateTimePicker::make( 'published_at' )
							->columnSpan( 1 )
							->required(),
						Select::make( 'user_id' )
							->relationship( 'author', 'name' )
							->preload()
							->searchable()
							->required()
							->columnSpan( 1 ),
						Select::make( 'categories' )
							->relationship( 'categories', 'title' )
							->preload()
							->multiple()
							->searchable(),
						Checkbox::make( 'featured' )
							->columnSpan( 2 ),

					] )->columns( 2 )
			] )->columns( 1 );
	}

	public static function table( Table $table ): Table {
		return $table
			->columns( [
				ImageColumn::make( 'image' ),
				TextColumn::make( 'title' )
					->wrap( true )
					->label( 'Title' )
					->searchable()
					->sortable()
					->toggleable(),
				TextColumn::make( 'slug' )
					->label( 'Slug' )
					->wrap()
					->sortable()
					->toggleable(),
				CheckboxColumn::make( 'featured' ),
				TextColumn::make( 'published_at' )->date(),
				TextColumn::make( 'author.name' ),
				TextColumn::make( 'categories.title' )
					->wrap( true ),
			] )
			->filters( [
				//
			] )
			->actions( [
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
				Tables\Actions\ForceDeleteAction::make(),
				Tables\Actions\RestoreAction::make(),
			] )
			->bulkActions( [
				Tables\Actions\BulkActionGroup::make( [
					Tables\Actions\DeleteBulkAction::make()
						->disabled( auth()->user()->isNotAdmin() ),
					Tables\Actions\ForceDeleteBulkAction::make()
						->disabled( auth()->user()->isNotAdmin() ),
					Tables\Actions\RestoreBulkAction::make()
						->disabled( auth()->user()->isNotAdmin() ),
				] ),
			] );
	}

	public static function getRelations(): array {
		return [
			CommentsRelationManager::class,
		];
	}

	public static function getPages(): array {
		return [
			'index' => Pages\ListPosts::route( '/' ),
			'create' => Pages\CreatePost::route( '/create' ),
			'edit' => Pages\EditPost::route( '/{record}/edit' ),
		];
	}
	public static function getEloquentQuery(): Builder {
		return parent::getEloquentQuery()
			->withoutGlobalScopes( [
				SoftDeletingScope::class,
			] );
	}
}
