<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;


class UserResource extends Resource {
	protected static ?string $model = User::class;

	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

	public static function form( Form $form ): Form {
		return $form
			->schema( [
				TextInput::make( 'name' )
					->required()
					->minLength( 2 )
					->maxLength( 100 ),
				TextInput::make( 'email' )
					->required()
					->email()
					->minLength( 2 )
					->maxLength( 100 ),
				TextInput::make( 'password' )
					->required()
					->password()
					->revealable()
					->minLength( 2 )
					->maxLength( 20 ),
				Select::make( 'role' )
					->options( User::ROLES )
					->default( User::ROLE_DEFAULT ),
			] );
	}

	public static function table( Table $table ): Table {
		return $table
			->columns( [
				TextColumn::make( 'name' )
					->searchable()
					->sortable()
					->toggleable(),
				TextColumn::make( 'email' )
					->searchable()
					->sortable()
					->toggleable(),
				TextColumn::make( 'role' )
					->searchable()
					->sortable()
					->toggleable()
					->badge()
					->color( fn( string $state ) => match ( $state ) {
						User::ROLE_ADMIN => 'danger',
						User::ROLE_EDITOR => 'warning',
						User::ROLE_USER => 'success',
					} ),
			] )
			->filters( [
				//
			] )
			->actions( [
				Tables\Actions\EditAction::make(),
			] )
			->bulkActions( [
				Tables\Actions\BulkActionGroup::make( [
					Tables\Actions\DeleteBulkAction::make(),
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
			'index' => Pages\ListUsers::route( '/' ),
			'create' => Pages\CreateUser::route( '/create' ),
			'edit' => Pages\EditUser::route( '/{record}/edit' ),
		];
	}
}
