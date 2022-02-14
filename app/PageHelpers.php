<?php

namespace App;

use Livewire\WithPagination;
use WireUi\Traits\Actions;

/**
 * 
 */
trait PageHelpers
{
  use WithPagination;
  use Actions;

  public $perPage = 10;
  public $isLoading = true;
  public $openModal = false;
  public $modalTitle = 'Tambah Data';
  public $search = null;
  public $ID = null;

  protected function setDefault()
  {
    $this->resetValidation();
    $this->resetExcept(['search', 'perPage']);
  }
}
