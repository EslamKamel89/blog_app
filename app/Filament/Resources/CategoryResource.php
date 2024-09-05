<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class CategoryResource extends Resource {
	protected static ?string $model = Category::class;

	protected static ?string $navigationIcon = 'heroicon-o-funnel';

	public static function form( Form $form ): Form {
		return $form
			->schema( [
				Section::make( 'Category' )
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
							->live( onBlur: true ),
						TextInput::make( 'slug' )
							->minLength( 1 )
							->maxLength( 150 )
							->required()
							->unique( ignoreRecord: true ),
						TextInput::make( 'text_color' )
							->nullable(),
						TextInput::make( 'bg_color' )
							->nullable(),
					] )->columnSpan( 1 ),
			] )->columns( 1 );
	}

	public static function table( Table $table ): Table {
		return $table
			->columns( [
				TextColumn::make( 'title' )
					->label( 'Title' )
					->searchable()
					->sortable()
					->toggleable(),
				TextColumn::make( 'slug' )
					->label( 'Slug' )
					->sortable()
					->toggleable(),
				TextColumn::make( 'text_color' )
					->label( 'Text Color' )
					->sortable()
					->toggleable( isToggledHiddenByDefault: true ),
				TextColumn::make( 'bg_color' )
					->label( 'Background Color' )
					->sortable()
					->toggleable( isToggledHiddenByDefault: true ),


			] )
			->filters( [
				//
			] )
			->actions( [
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
			] )
			->bulkActions( [
				Tables\Actions\BulkActionGroup::make( [
					Tables\Actions\DeleteBulkAction::make()
						->disabled( auth()->user()->isNotAdmin() ),
				] ),
			] );
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => Pages\ListCategories::route( '/' ),
			'create' => Pages\CreateCategory::route( '/create' ),
			'edit' => Pages\EditCategory::route( '/{record}/edit' ),
		];
	}
}
